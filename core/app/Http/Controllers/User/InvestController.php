<?php

namespace App\Http\Controllers\User;

use App\Models\Invest;
use App\Models\Property;
use App\Constants\Status;
use App\Lib\PropertyInvest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\GatewayCurrency;
use App\Models\Installment;

class InvestController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'invest_amount' => 'required|numeric|gt:0',
            'method'        => 'required|in:gateway,balance',
            'currency'      => 'required_if:method,gateway',
            'gateway'       => 'required_if:method,gateway',
        ]);

        try {
            $id = decrypt($id);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Invalid request'];
            return back()->withNotify($notify);
        }

        $property = Property::where('id', $id)->withCount('invests')->first();

        if (!$property) {
            $notify[] = ['error', 'Invalid Property'];
            return back()->withNotify($notify);
        }

        if ($property->invests_count == $property->total_share) {
            $notify[] = ['error', 'Property is not available for invest'];
            return back()->withNotify($notify);
        }

        $user   = auth()->user();
        $amount = $property->per_share_amount;

        if ($property->invest_type == Status::INVEST_TYPE_INSTALLMENT && $request->invest_full_amount != 'true') {
            $amount = ($property->per_share_amount / 100) * $property->down_payment;
        }

        $isFullAmount = $request->invest_full_amount == 'true' || $property->invest_type == Status::INVEST_TYPE_ONETIME;

        if ($request->method == 'gateway') {
            return $this->gateWayPayment($request, $amount, $property->id, isFullAmount: $isFullAmount);
        }

        if ($amount > $user->balance) {
            $notify[] = ['error', 'You don\'t have sufficient balance'];
            return back()->withNotify($notify);
        }

        if ($isFullAmount) {
            $paymentType = Status::INVEST_TYPE_ONETIME;
        }

        $propertyInvest = new PropertyInvest($property, paymentType: @$paymentType);
        $invest         = $propertyInvest->invest($amount);

        $notify[] = ['success', 'Property invested successfully'];

        if (@$paymentType) return to_route('user.invest.history')->withNotify($notify);

        return to_route('user.invest.installment.details', encrypt($invest->id))->withNotify($notify);
    }

    public function installmentPay(Request $request, $id, $installmentId)
    {
        $request->validate([
            'installment_amount' => 'required|numeric|gt:0',
            'method'             => 'required|in:gateway,balance',
            'currency'           => 'required_if:method,gateway',
            'gateway'            => 'required_if:method,gateway',
        ]);
        try {
            $id            = decrypt($id);
            $installmentId = decrypt($installmentId);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Invalid request'];
            return back()->withNotify($notify);
        }

        $user   = auth()->user();
        $invest = Invest::where('id', $id)->where('user_id', $user->id)->with(['property', 'installments' => function ($q) use ($installmentId) {
            $q->where('id', $installmentId)->where('status', Status::INSTALLMENT_PENDING);
        }])->firstOrFail();

        $nextInstallment = Installment::where('invest_id', $id)->where('status', Status::INSTALLMENT_PENDING)->first();

        if ($invest->installments[0]->id != $nextInstallment->id) {
            $notify[] = ['error', 'Pay previous installment first'];
            return back()->withNotify($notify);
        }

        $installmentAmount = $invest->per_installment_amount + $invest->installments[0]->late_fee;

        if ($installmentAmount != $request->installment_amount) {
            $notify[] = ['error', 'Invalid amount'];
            return back()->withNotify($notify);
        }
        if ($request->method == 'gateway') {
            return $this->gateWayPayment($request, $installmentAmount, 0, $id, $installmentId);
        }

        if ($installmentAmount > $user->balance) {
            $notify[] = ['error', 'Don\'t have sufficient balance'];
            return back()->withNotify($notify);
        }

        $propertyInvest = new PropertyInvest($invest->property, $invest, $invest->installments[0]);
        $invest         = $propertyInvest->invest($invest->per_installment_amount, $invest->installments[0]->late_fee);

        $notify[] = ['success', 'Installment paid successfully'];
        return to_route('user.invest.installment.details', encrypt($id))->withNotify($notify);
    }

    public function installmentDetails($id)
    {
        $pageTitle = 'Installment Details';

        try {
            $id = decrypt($id);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Invalid request'];
            return back()->withNotify($notify);
        }
        $invest = Invest::where('id', $id)->where('user_id', auth()->id())->with(['installments', 'property'])->firstOrFail();
        return view($this->activeTemplate . 'user.invest.installment', compact('pageTitle', 'invest'));
    }

    public function investHistory()
    {
        $pageTitle = 'Invest History';
        $invests   = Invest::where('user_id', auth()->id())
            ->with(['property', 'property.profitScheduleTime', 'installments' => function ($installments) {
                $installments->where('status', Status::INSTALLMENT_PENDING);
            }])
            ->searchable(['property:title'])
            ->orderByDesc('id')
            ->paginate(getPaginate());

        return view($this->activeTemplate . 'user.invest.history', compact('pageTitle', 'invests'));
    }


    private function gateWayPayment($request, $amount = 0, $propertyId, $investId = 0, $installmentId = 0, $isFullAmount = 0)
    {
        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', Status::ENABLE);
        })->where('method_code', $request->gateway)->where('currency', $request->currency)->first();


        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        $charge       = $gate->fixed_charge + ($amount * $gate->percent_charge / 100);
        $payable      = $amount + $charge;
        $final_amount = $payable * $gate->rate;

        $data                  = new Deposit();
        $data->user_id         = $user->id;
        $data->property_id     = $propertyId;
        $data->invest_id       = $investId;
        $data->installment_id  = $installmentId;
        $data->payment_type    = $isFullAmount;
        $data->method_code     = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount          = $amount;
        $data->invest_amount   = $amount;
        $data->charge          = $charge;
        $data->rate            = $gate->rate;
        $data->final_amount    = $final_amount;
        $data->btc_amount      = 0;
        $data->btc_wallet      = "";
        $data->trx             = getTrx();
        $data->save();

        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }
}
