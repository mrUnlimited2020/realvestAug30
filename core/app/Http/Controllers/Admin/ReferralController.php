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
            'deposit_commission' => 'Deposit Commission',
            'profit_commission'  => 'Profit Commission',
            'thrift_commission'  => 'Thrift Commission',
            'easyland_commission'  => 'Easyland Commission',
            'regular_reg_commission'  => 'Regular Reg Commission',
            'ass_mbmr_reg_commission'  => 'Ass Mbmr Reg Commission',
            'ass_prtnr_reg_commission'  => 'Ass Prtnr Reg Commission',
            'rentals_commission'  => 'Rentals Commission',
            'ass_mbmr_rentals_commission'  => 'Ass Mbmr Rentals Commission',
            'ass_prtnr_rentals_commission'  => 'Ass Prtnr Rentals Commission',
            'voucher_commission'  => 'Voucher Commission',
            'ass_mbmr_voucher_commission'  => 'Ass Mbmr Voucher Commission',            
            'ass_prtnr_voucher_commission'  => 'Ass Prtnr Voucher Commission',
            'food_community_commission'  => 'Food_Community Commission',
            'garri_commission'   => 'Garri Commission',
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
            'commission_type' => 'required|in:deposit_commission,regular_reg_commission,profit_commission,rentals_commission,voucher_commission,thrift_commission,easyland_commission,ass_mbmr_reg_commission,ass_prtnr_reg_commission,ass_mbmr_rentals_commission,ass_prtnr_rentals_commission,ass_mbmr_voucher_commission,ass_prtnr_voucher_commission,food_community_commission,garri_commission',
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
