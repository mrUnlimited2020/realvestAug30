<?php

namespace App\Http\Controllers\Admin;

use App\Models\Referral;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle       = 'Manage Referral';
        $referrals       = Referral::get();
        $commissionTypes = [
            'easyland_commission'  => 'Easyland Commission',
            'bronze_mbmr_reg_commission'  => 'Bronze Mbmr Reg Commission',
            'silver_mbmr_reg_commission'  => 'Silver Mbmr Reg Commission',
            'gold_mbmr_reg_commission'  => 'Gold Mbmr Reg Commission',
            'rentals_commission'  => 'Rentals Commission',
            'voucher_commission'  => 'Voucher Commission',
            'bronze_sales_invest_comm' => 'Bronze Sales Invest',
            'silver_sales_invest_comm' => 'Silver Sales Invest',
            'gold_sales_invest_comm' => 'Gold Sales Invest',
            'bronze_prtnr_fdreg_comm' => 'Bronze Prtnr FdComm',
            'silver_prtnr_fdreg_comm' => 'Silver Prtnr FdComm',
            'gold_prtnr_fdreg_comm' => 'Gold Prtnr FdComm',
            'diamond_prtnr_fdreg_comm' => 'Diamond Prtnr FdComm',
            'bronze_sales_comm' => 'Bronze Sales',
            'silver_sales_comm' => 'Silver Sales',
            'gold_sales_comm' => 'Gold Sales',
            'diamond_sales_comm' => 'Diamond Sales',
        ];
        return view('admin.referral.index', compact('pageTitle', 'referrals', 'commissionTypes'));
    }

    public function status($type)
    {
        return GeneralSetting::changeStatus(1, $type);
    }

    public function update(Request $request)
    {
        $request->validate([
            'percent'         => 'required',
            'percent*'        => 'required|numeric',
            'commission_type' => 'required|in:bronze_mbmr_reg_commission,rentals_commission,voucher_commission,easyland_commission,silver_mbmr_reg_commission,gold_mbmr_reg_commission,bronze_sales_invest_comm,silver_sales_invest_comm,gold_sales_invest_comm,bronze_prtnr_fdreg_comm,silver_prtnr_fdreg_comm,gold_prtnr_fdreg_comm,diamond_prtnr_fdreg_comm,bronze_sales_comm,silver_sales_comm,gold_sales_comm,diamond_sales_comm',
        ]);
        $type = $request->commission_type;

        Referral::where('commission_type', $type)->delete();

        for ($i = 0; $i < count($request->percent); $i++) {
            $referral                  = new Referral();
            $referral->level           = $i + 1;
            $referral->percent         = $request->percent[$i];
            $referral->commission_type = $request->commission_type;
            $referral->save();
        }

        $notify[] = ['success', 'Referral commission setting updated successfully'];
        return back()->withNotify($notify);
    }
}
