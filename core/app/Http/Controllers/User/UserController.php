<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\User;
use App\Models\Invest;
use App\Models\Profit;
use App\Models\Deposit;
use App\Models\Referral;
use App\Constants\Status;
use App\Lib\FormProcessor;
use App\Models\Withdrawal;
use App\Models\Installment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Lib\GoogleAuthenticator;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle                     = 'Dashboard';
        $user                          = auth()->user();
        $paidAmountSum                 = Invest::where('user_id', $user->id)->sum('paid_amount');
        $registrationFeeSum            = Invest::where('user_id', $user->id)->sum('rglr_reg_fee');
        $totalAfterFees                = $paidAmountSum - $registrationFeeSum;
        $totalInvestments              = Invest::where('user_id', $user->id)->count();
        $userId                        = $user->id;
        $propertyId                    = [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
        $teamSalesVolume               = function($userId, $propertyId){
            $directReferrals           = User::where('id', $userId)->pluck('id')->toArray();

            $secondLevelReferrals      = User::whereIn('ref_by', $directReferrals)->pluck('id')->toArray();

            $thirdLevelReferrals       = User::whereIn('ref_by', $secondLevelReferrals)->pluck('id')->toArray();

            $allUserIds                = array_merge([$userId], $directReferrals, $secondLevelReferrals, $thirdLevelReferrals);
            $totalAmount               = Invest::whereIn('user_id', $allUserIds)->whereIn('property_id', $propertyId)->sum('paid_amount');
            $formattedAmount           = number_format($totalAmount, 2, '.', ',');
            return $formattedAmount;
        };
        $widget['team_sales_volume']   = $teamSalesVolume($userId, $propertyId);
        $widget['total_property']       = $totalInvestments;
        $widget['balance']             = $user->balance;
        $widget['total_deposit']       = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw']      = Withdrawal::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_investment']    = $paidAmountSum;
        $widget['total_profit']        = Invest::where('user_id', $user->id)->where('invest_status', Status::COMPLETED)->sum('total_profit');
        $widget['referral']            = User::where('ref_by', $user->id)->count();
        $widget['referral_balance'] = $user->referral_balance;
        $widget['psq_invest']          = Invest::where('user_id', $user->id)->sum('psq_invest');
        $widget['thrift_invest']       = Invest::where('user_id', $user->id)->sum('thrift_invest');
        $widget['v_landlord_invest']   = Invest::where('user_id', $user->id)->sum('v_landlord_invest');
        $widget['total_after_fees']    = $totalAfterFees;
        $widget['total_ticket']        = SupportTicket::where('user_id', $user->id)->count();
        $nextProfitSchedule            = Invest::where('user_id', $user->id)->with('property')->where('profit_status', Status::RUNNING)->orderBy('next_profit_date')->first();

        $nextInstallment               = Installment::whereHas('invest', function ($invest) use ($user) {
            $invest->where('user_id', $user->id);
        })->where('status', Status::INSTALLMENT_PENDING)->orderBy('next_time')->with(['invest'])->first();


        $trxReport['date'] = collect([]);
        $investTrx         = Transaction::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('remark', 'down_payment')->orWhere('remark', 'installment');
            })
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();

        $investTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });
        $profitTrx = Transaction::where('user_id', $user->id)->where('remark', 'profit')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();
        $profitTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });
        $trxReport['date'] = dateSorting($trxReport['date']->unique()->toArray());


        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'widget', 'nextInstallment', 'investTrx', 'profitTrx', 'trxReport', 'user', 'nextProfitSchedule'));
    }
    
     public function fdComHome()
    {
        $pageTitle                     = 'Mall Dashboard';
        $user                          = auth()->user();
        $paidAmountSum                 = Invest::where('user_id', $user->id)->sum('paid_amount');
        $registrationFeeSum            = Invest::where('user_id', $user->id)->sum('rglr_reg_fee');
        $directSalesComm               = $user->direct_sales_comm;
        $referralsSalesComm            = $user->referrals_sales_comm;
        $totalAfterFees                = $paidAmountSum - $registrationFeeSum;
        $totalInvestments              = Invest::where('user_id', $user->id)->count();
        $userId                        = $user->id;
        $foodCommPropertyId            = 19;
        $foodCommTeamSalesVolume       = function($userId, $foodCommPropertyId){
            $directReferrals           = User::where('id', $userId)->pluck('id')->toArray();

            $secondLevelReferrals      = User::whereIn('ref_by', $directReferrals)->pluck('id')->toArray();

            $thirdLevelReferrals       = User::whereIn('ref_by', $secondLevelReferrals)->pluck('id')->toArray();

            $allUserIds                = array_merge([$userId], $directReferrals, $secondLevelReferrals, $thirdLevelReferrals);
            $totalAmountFoodComm       = Invest::whereIn('user_id', $allUserIds)->where('property_id', $foodCommPropertyId)->sum('paid_amount');
            return number_format($totalAmountFoodComm, 2, '.', '');
        };
        
        $foodCommformattedAmount       = $foodCommTeamSalesVolume($userId, $foodCommPropertyId);
        $totalAmountFoodComm           = floatval(str_replace(',', '', $foodCommformattedAmount)); // Convert foodCommformattedAmount to float for comparison
        
        //This is for SCASH............
        // Define thresholds and corresponding profits
        $levels = [
            1 => 10500000,
            2 => 21000000,
            3 => 35000000,
            4 => 52500000,
            5 => 70000000,
            6 => 105000000,
            7 => 210000000,
            8 => 315000000,
            9 => 420000000,
            10 => 525000000,
            11 => 630000000,
            12 => 735000000
        ];

        $profits = [
            1 => 2010000,
            2 => 4020000,
            3 => 6700000,
            4 => 10050000,
            5 => 13400000,
            6 => 20100000,
            7 => 40200000,
            8 => 60300000,
            9 => 80400000,
            10 => 100500000,
            11 => 120600000,
            12 => 140700000
        ];
        // Initialize SCASH variables
        $scash = [
            'total' => 0,
            'part1' => 0,
            'part2' => 0
        ];

        // Determine the SCASH based on levels
        foreach ($levels as $level => $threshold) {
            if ($totalAmountFoodComm >= $threshold) {
                $profit = $profits[$level];
                $scash['total'] = $profit;
                $scash['part1'] = $profit * 0.30 / 500;
                $scash['part2'] = $profit * 0.70;
            }
        };
        
        $widget['total_property']      = $totalInvestments;
        $widget['balance']             = $user->balance;
        $widget['total_deposit']       = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw']      = Withdrawal::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_investment']    = $paidAmountSum;
        $widget['total_profit']        = Invest::where('user_id', $user->id)->where('invest_status', Status::COMPLETED)->sum('total_profit');
        $widget['referral']            = User::where('ref_by', $user->id)->count();
        $widget['direct_sales_comm']   = $directSalesComm;
        $widget['referrals_sales_comm'] = $referralsSalesComm;
        $widget['sales_balance']        = $referralsSalesComm + $directSalesComm;
        $widget['food_comm_team_sales_volume']   = $foodCommTeamSalesVolume($userId, $foodCommPropertyId);
        $widget['food_comm_user_scash']          = $scash['part1'];
        $widget['food_comm_coy_scash']           = $scash['part2'];

        $nextInstallment               = Installment::whereHas('invest', function ($invest) use ($user) {
            $invest->where('user_id', $user->id);
        })->where('status', Status::INSTALLMENT_PENDING)->orderBy('next_time')->with(['invest'])->first();


        $trxReport['date'] = collect([]);
        $investTrx         = Transaction::where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('remark', 'down_payment')->orWhere('remark', 'installment');
            })
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();

        $investTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });
        $profitTrx = Transaction::where('user_id', $user->id)->where('remark', 'profit')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw("SUM(amount) as amount, DATE_FORMAT(created_at,'%Y-%m-%d') as date")
            ->orderBy('created_at')
            ->groupBy('date')
            ->get();
        $profitTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });
        $trxReport['date'] = dateSorting($trxReport['date']->unique()->toArray());


        return view($this->activeTemplate . 'user.fdcomdashboard', compact('pageTitle', 'widget', 'nextInstallment', 'investTrx', 'profitTrx', 'trxReport', 'user'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . gs('site_name'), $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl', 'user'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->orderBy('id', 'desc')->paginate(getPaginate());

        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act', 'kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ];
        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function referrals()
    {
        $pageTitle = 'Referrals';
        $user      = auth()->user();
        $maxLevel  = Referral::max('level');
        return view($this->activeTemplate . 'user.referrals', compact('pageTitle', 'user', 'maxLevel'));
    }

    public function profitHistory()
    {
        $pageTitle = 'Profit History';
        $profits = Profit::where('user_id', auth()->id())
            ->success()
            ->searchable(['transaction:trx', 'invest:investment_id', 'property:title'])
            ->with(['user', 'property', 'invest', 'transaction'])
            ->orderByDesc('updated_at')
            ->paginate(getPaginate());

        return view($this->activeTemplate . 'user.profit', compact('pageTitle', 'profits'));
    }
}
