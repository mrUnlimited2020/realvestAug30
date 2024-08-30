<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Models\Invest;
use App\Http\Controllers\Controller;
use App\Lib\PropertyInvest;
use App\Models\Installment;
use App\Models\Profit;
use App\Models\Property;
use Illuminate\Http\Request;

class InvestController extends Controller
{
    public function all()
    {
        $pageTitle  = 'All Investment';
        $investData = $this->investData(null, true);
        extract($investData);
        return view('admin.invest.index', compact('pageTitle', 'invests', 'investStatistics'));
    }
    public function running()
    {
        $pageTitle  = 'Running Investment';
        $investData = $this->investData('running');
        extract($investData);
        return view('admin.invest.index', compact('pageTitle', 'invests', 'investStatistics'));
    }

    public function completed()
    {
        $pageTitle  = 'Completed  Investment';
        $investData = $this->investData('completed');
        extract($investData);
        return view('admin.invest.index', compact('pageTitle', 'invests', 'investStatistics'));
    }

    private function investData($scope = null, $widget = false)
    {
        $invests = Invest::searchable(['user:username', 'property:title', 'investment_id'])->filter(['invest_status', 'profit_status'])->with('user', 'property')->orderBy('id', 'desc');

        if ($scope) {
            $invests->$scope();
        }
        if ($widget) {
            $investStatistics['total_invested_property'] = Property::whereHas('invests')->count();
            $investStatistics['running_invest_amount']   = Invest::where('invest_status', Status::RUNNING)->sum('total_invest_amount');
            $investStatistics['completed_invest_amount'] = Invest::where('invest_status', Status::COMPLETED)->sum('total_invest_amount');
            $investStatistics['all_invest_amount']       = Invest::sum('total_invest_amount');
        } else {
            $investStatistics = [];
        }
        $invests = $invests->paginate(getPaginate());
        return compact('investStatistics', 'invests');
    }

    public function investmentDetails($id)
    {
        $pageTitle    = 'Investment Details';
        $invest       = Invest::with(['property', 'user', 'installments'])->where('id', $id)->firstOrFail();
        $installments = $invest->installments;
        $profits = Profit::where('invest_id', $id)
            ->with(['user', 'invest', 'property', 'transaction'])
            ->get();

        return view('admin.invest.details', compact('pageTitle', 'invest', 'installments', 'profits'));
    }

    public function installment()
    {
        $pageTitle    = 'Installment History';
        $installments = Installment::with(['invest', 'invest.user', 'invest.property'])
            ->searchable(['invest.user:username', 'invest.property:title', 'invest:investment_id'])
            ->filter(['status'])
            ->orderByDesc('status')
            ->orderBy('next_time')
            ->paginate(getPaginate());

        return view('admin.invest.installment', compact('pageTitle', 'installments'));
    }

    public function profit()
    {
        $pageTitle  = 'Profit History';
        $profitList = Profit::success()
            ->searchable(['user:username', 'property:title', 'transaction:trx'])
            ->with(['user', 'invest', 'property', 'transaction'])
            ->orderByDesc('updated_at')
            ->paginate(getPaginate());
        return view('admin.invest.profit', compact('pageTitle', 'profitList'));
    }

    public function pendingProfit()
    {
        $pageTitle = 'Pending Profits';
        $profitList = Profit::pending()
            ->searchable(['user:username', 'property:title'])
            ->with(['user', 'invest', 'property'])
            ->groupBy('property_id')
            ->selectRaw('*, COUNT(*) as total_investor')
            ->paginate(getPaginate());

        return view('admin.invest.profit', compact('pageTitle', 'profitList'));
    }

    public function dischargeProfit(Request $request, $id)
    {
        $request->validate([
            'new_profit_amount' => 'required|numeric'
        ]);

        $property = Property::findOrFail($id);
        $profits  = Profit::pending()->where('property_id', $property->id)->with(['user', 'invest', 'property'])->get();

        foreach ($profits as $profit) {

            $propertyInvest = new PropertyInvest($profit->property, $profit->invest, user: $profit->user);
            $profitAmount   = $propertyInvest->calProfit($profit, $request->new_profit_amount);

            $profit->amount = $profitAmount;
            $profit->status = Status::PROFIT_SUCCESS;
            $profit->save();
        }

        $notify[] = ['success', 'Profit discharged completed successfully'];
        return back()->withNotify($notify);
    }
}
