<?php

namespace App\Lib;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Invest;
use App\Models\Referral;
use App\Constants\Status;
use App\Models\Installment;
use App\Models\Transaction;
use App\Models\AdminNotification;

class PropertyInvest
{
    protected $user;
    protected $property;
    protected $invest;
    protected $installment;
    protected $trx;
    protected $notificationTemplate;
    protected $paymentType;

    public function __construct($property = null, $invest = null, $installment = null, $user = null, $paymentType = null)
    {
        if (!$user) {
            $this->user = auth()->user();
        } else {
            $this->user = $user;
        }
        $this->property    = $property;
        $this->installment = $installment;
        $this->invest      = $invest;
        $this->paymentType = $paymentType;
    }

    // NB: invest starts here
    public function invest($amount, $duration, $lateFee = 0)
    {
        if (!$this->installment) {
            $this->createInvest($amount, $duration);
            if (!$this->paymentType && $this->property->invest_type == Status::INVEST_TYPE_INSTALLMENT) {
                $this->createInvestInstallment();
            }
        } else {
            $this->invest->paid_amount += $this->invest->per_installment_amount;
            $this->invest->due_amount  -= $this->invest->per_installment_amount;
            $this->invest->save();

            $this->installment->status    = Status::INSTALLMENT_SUCCESS;
            $this->installment->paid_time = now();
            $this->installment->save();
        }

        $totalInvestedAmount           = $this->property->invested_amount + $amount;
        $this->property->invest_status = Status::PROPERTY_RUNNING;

        if (($this->property->goal_amount - $totalInvestedAmount) <= 0) {
            $this->property->invest_status = Status::PROPERTY_COMPLETED;
        }

        $this->property->invested_amount += $amount;
        $this->property->save();

        if ($this->invest->total_invest_amount <= $this->invest->paid_amount) {
            $this->invest->invest_status    = Status::COMPLETED;
            $this->invest->due_amount       = 0;
            $this->invest->profit_status    = Status::RUNNING;
            $this->invest->next_profit_date = now()->addDays($this->property->profit_back);
        }
        
        //New Tables For Different Wallets and to determine the property name
        //Pls NB: Always correct this title(on the server) to reflect the server title
        
        //PSQ Voucher
        if($this->property->id == 10){
            $this->invest->psq_invest = $this->invest->paid_amount;
            $this->invest->property_name = 'voucher_package';
        }
        
         //Fufu starts here
        elseif($this->property->id == 32){
            $this->invest->odourless_fufu = $this->invest->paid_amount;
            $this->invest->property_name = 'odourless_fufu';
        }
        
        //Grains start here 
        elseif  ($this->property->id == 22    //White Garri 12.5kg
        || $this->property->id == 21          //One paint bucket (Sealed)
        || $this->property->id == 29          //Clean Sweet Rice x 10 Cups  
        || $this->property->id == 30          //Honey Beans x 10 Cups
        || $this->property->id == 35) {       //White Beans x 10 Cups
            $this->invest->grains = $this->invest->paid_amount;
            $this->invest->property_name = 'grains';
        }
        
        //Fish starts here
        elseif ($this->property->id == 46    //Stockfish
        || $this->property->id == 36    //148g Oron Ground Crayfish
        || $this->property->id == 37    //550g Oron Ground Crayfish
        || $this->property->id == 25){       //Sweet Oron Crayfish @1.5k
            $this->invest->fish = $this->invest->paid_amount;
            $this->invest->property_name = 'fish';
        }

        //Ingredients starts here
        elseif ($this->property->id == 27    //Topisto Tomato Mix 70g
        || $this->property->id == 38    //2g Ground Ogbono
        || $this->property->id == 39    //38g Ground Pepper
        || $this->property->id == 44    //Hand-broken melon
        || $this->property->id == 28){       //110ml Power Oil        
            $this->invest->ingredients = $this->invest->paid_amount;
            $this->invest->property_name = 'ingredients';
        }

        //Custard starts here
        elseif ($this->property->id == 33    //45g Checkers Custard
        || $this->property->id == 34){       //700gms Checkers Custard 
            $this->invest->custard = $this->invest->paid_amount;
            $this->invest->property_name = 'custard';
        }
        
        //Leaf starts here
        elseif ($this->property->id == 45    //Atama Leaf
        || $this->property->id == 47){       //Afang Leaf
            $this->invest->leaf = $this->invest->paid_amount;
            $this->invest->property_name = 'leaf';
        }

        //Other Food Items. Eg. Manual Presser starts here
        elseif ($this->property->id == 23){    //Heavy Duty Manual Fruit Presser
            $this->invest->other_fdcom_items = $this->invest->paid_amount;
            $this->invest->property_name = 'other_fdcom_items_commission';
        }
        
        elseif ($this->property->title == 'THRIFT') {
            $this->invest->thrift_invest = $this->invest->paid_amount;
            $this->invest->property_name = 'thrift_package';
        }
        
        elseif  ($this->property->title == 'Virtual Landlord') {
            $this->invest->v_landlord_invest = $this->invest->paid_amount;
            $this->invest->property_name = 'rentals_package';
        }

        //Addition of new feature for other kinds of members begin here
        elseif  ($this->property->title == 'Bronze Member' 
        || $this->property->title == 'Silver Member'  
        || $this->property->title == 'Gold Member') {
            if($this->invest->paid_amount == 2500){
                $this->invest->bronze_mbmr_reg_fee = $this->invest->paid_amount;
                $this->invest->property_name = 'bronze_member_reg';
                $this->user->partnership_type = 'Bronze Member';
            }
            elseif($this->invest->paid_amount == 30000){
                $this->invest->silver_mbmr_reg_fee = $this->invest->paid_amount;
                $this->invest->property_name = 'silver_member_reg';
                $this->user->partnership_type = 'Silver Member';
            }
            elseif($this->invest->paid_amount == 45000){
                $this->invest->gold_mbmr_reg_fee = $this->invest->paid_amount;
                $this->invest->property_name = 'gold_member_reg';
                $this->user->partnership_type = 'Gold Member';
            }
        }
        elseif  ($this->property->title == 'Easy Land') {
            $this->invest->easyland_invest = $this->invest->paid_amount;
            $this->invest->property_name = 'easyland_package';
        }
        
        //Addition of new feature for other kinds of partners for foodmall begin here
        elseif($this->property->id == 40) {
            $this->invest->basic_prtnr_fdreg = $this->invest->paid_amount;
            $this->invest->property_name = 'bronze_prtnr_fdreg';
            $this->user->partnership_type = 'Bronze Partner';
        }
        elseif($this->property->id == 41) {
            $this->invest->silver_prtnr_fdreg = $this->invest->paid_amount;
            $this->invest->property_name = 'silver_prtnr_fdreg';
            $this->user->partnership_type = 'Silver Partner';
        }
        elseif($this->property->id == 42) {
            $this->invest->gold_prtnr_fdreg = $this->invest->paid_amount;
            $this->invest->property_name = 'gold_prtnr_fdreg';
            $this->user->partnership_type = 'Gold Partner';
        }
        elseif($this->property->id == 43) {
            $this->invest->diamond_prtnr_fdreg = $this->invest->paid_amount;
            $this->invest->property_name = 'diamond_prtnr_fdreg';
            $this->user->partnership_type = 'Diamond Partner';
        }

        $this->invest->save();

        $this->trx = getTrx();

        $this->createLateFee($lateFee);

        if ($this->installment) {
            $this->installment->save();
            $transactionDetails = 'Installment payment on ';
            $remark = 'installment';
            $this->notificationTemplate = 'INSTALLMENT';
        } else {
            $this->invest->save();
            $transactionDetails = 'Investment payment on ';
            $remark = 'down_payment';
            $this->notificationTemplate = 'DOWN_PAYMENT';
        }


       $this->user->balance -= $amount;
       $this->user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $this->user->id;
        $transaction->invest_id    = $this->invest->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $this->user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = $transactionDetails . $this->property->title . ' property';
        $transaction->trx          = $this->trx;
        $transaction->remark       = $remark;
        $transaction->save();

        notify($this->user, $this->notificationTemplate, [
            'trx'             => $this->trx,
            'amount'          => showAmount($amount),
            'property_name'   => $this->property->title,
            'post_balance'    => showAmount($this->user->balance),
            'paid_amount'     => showAmount($this->invest->paid_amount),
            'due_amount'      => showAmount($this->invest->due_amount),
            'invested_amount' => showAmount($this->invest->total_invest_amount),
        ]);

        if ($this->invest->invest_status == Status::COMPLETED) {
            notify($this->user, 'INVESTMENT', [
                'amount'          => showAmount($this->invest->total_invest_amount),
                'property_name'   => $this->property->title,
                'post_balance'    => showAmount($this->user->balance),
                'paid_amount'     => showAmount($this->invest->paid_amount),
                'due_amount'      => showAmount($this->invest->due_amount),
            ]);
        }

        $commissionTypeMapping = [
            'Basic Partner'   => 'bronze_sales_comm',
            'Bronze Partner'   => 'bronze_sales_comm',
            'Silver Partner'  => 'silver_sales_comm',
            'Gold Partner'    => 'gold_sales_comm',
            'Diamond Partner' => 'diamond_sales_comm',
        ];

        $partnershipType = $this->user->partnership_type;
        $commissionType = $commissionTypeMapping[$partnershipType] ?? 'default_commission'; // Provide a default commission type if needed
        
        //This is for commision based on member type for investment on sales
        $investCommissionTypeMapping = [
            'Bronze Member'   => 'bronze_sales_invest_comm',
            'Silver Member'  => 'silver_sales_invest_comm',
            'Gold Member'    => 'gold_sales_invest_comm',
        ];

        $membershipType = $this->user->partnership_type;
        $investCommissionType = $investCommissionTypeMapping[$membershipType] ?? 'default_commission'; // Provide a default commission type if needed
        
        
        switch ($this->invest->property_name) {
            case 'thrift_package':
                if (gs()->thrift_commission && $this->user->ref_by) {
                    $this->referralCommission('thrift_commission', $amount);
                }
                break;
            case 'bronze_prtnr_fdreg':
                if (gs()->basic_prtnr_fdreg_comm && $this->user->ref_by) {
                    $this->fdRegReferralCommission('bronze_prtnr_fdreg_comm', $amount);
                }
                break;
            case 'silver_prtnr_fdreg':
                if (gs()->silver_prtnr_fdreg_comm && $this->user->ref_by) {
                    $this->fdRegReferralCommission('silver_prtnr_fdreg_comm', $amount);
                }
                break;
            case 'gold_prtnr_fdreg':
                if (gs()->gold_prtnr_fdreg_comm && $this->user->ref_by) {
                    $this->fdRegReferralCommission('gold_prtnr_fdreg_comm', $amount);
                }
                break;
            case 'diamond_prtnr_fdreg':
                if (gs()->basic_prtnr_fdreg_comm && $this->user->ref_by) {
                    $this->fdRegReferralCommission('diamond_prtnr_fdreg_comm', $amount);
                }
                break;
            case 'odourless_fufu':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
            
            case 'other_fdcom_items_commission':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
            
            case 'grains':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
            
            case 'ingredients':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
                
            case 'fish':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
                
            case 'custard':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
                
            case 'leaf':
                if (gs()->$commissionType && $this->user->ref_by) {
                    $this->foodComRefPartnerComm($commissionType, $amount);
                }
                break;
                
            case 'bronze_member_reg':
                if (gs()->bronze_mbmr_reg_commission && $this->user->ref_by) {
                    $this->referralCommission('bronze_mbmr_reg_commission', $amount);
                }
                break;

            case 'gold_member_reg':
                if (gs()->gold_mbmr_reg_commission && $this->user->ref_by) {
                    $this->referralCommission('gold_mbmr_reg_commission', $amount);
                }
                break;
            
            case 'silver_member_reg':
                if (gs()->silver_mbmr_reg_commission && $this->user->ref_by) {
                    $this->referralCommission('silver_mbmr_reg_commission', $amount);
                }
                break;

            case 'rentals_package':
                if (gs()->$investCommissionType && $this->user->ref_by) {
                    $this->investReferralCommission($investCommissionType, $amount);
                }
                break;
                
            case 'voucher_package':
                if (gs()->$investCommissionType && $this->user->ref_by) {
                    $this->investReferralCommission($investCommissionType, $amount);
                }
                break;

            case 'easyland_package':
                if (gs()->$investCommissionType && $this->user->ref_by) {
                    $this->investReferralCommission($investCommissionType, $amount);
                }
                break;
            
            default:
                // Handle unknown package type
                break;
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $this->user->id;
        $adminNotification->title     = gs()->cur_sym . showAmount($amount) . ' invested to ' . $this->property->title;
        $adminNotification->click_url = '#';
        $adminNotification->save();

        return $this->invest;
    }

    //added duration here to reflect on the db
    protected function createInvest($amount, $duration)
    {
        $perInstallmentAmount = 0;

        if (!$this->paymentType && $this->property->invest_type == Status::INVEST_TYPE_INSTALLMENT) {
            $perInstallmentAmount = $this->property->per_installment_amount;
        }

        $invest                         = new Invest();
        $invest->user_id                = $this->user->id;
        $invest->property_id            = $this->property->id;
        $invest->investment_id          = getTrx(10);
        $invest->total_invest_amount    = $amount; //updated to reflect user input amount
        $invest->initial_invest_amount  = $amount;
        $invest->paid_amount            = $amount;
        $invest->invest_duration        = $duration; //duration table and value added
        $invest->due_amount             = $this->property->per_share_amount - $amount;
        $invest->per_installment_amount = $perInstallmentAmount;
        $invest->profit_status          = Status::INVESTMENT_RUNNING;
        $invest->save();

        $this->invest = $invest;
    }

    protected function createInvestInstallment()
    {
        $prevInstallment = null;

        for ($i = 0; $i < $this->property->total_installment; $i++) {
            $installment            = new Installment();
            $installment->invest_id = $this->invest->id;

            if ($prevInstallment) {
                $time            = $prevInstallment->next_time;
                $nextInstallment = Carbon::parse($time)->addHours($this->property->installmentDuration->time);
            } else {
                $nextInstallment = now()->addHours($this->property->installmentDuration->time);
            }

            $installment->next_time = $nextInstallment;
            $installment->status    = Status::INSTALLMENT_PENDING;
            $installment->save();

            $prevInstallment = $installment;
        }
    }

    public function calProfit($profit, $amount = 0)
    {
        if ($amount) {
            $profitAmount = $this->getProfitAmount($amount);
        } else {
            $profitAmount = $this->getProfitAmount();
        }

        $general = gs();

        if ($profitAmount) {
            if ($this->property->is_capital_back == Status::CAPITAL_BACK_YES && $this->invest->get_profit_count == 0) {

                $this->user->balance += $this->invest->total_invest_amount;
                $this->user->save();

                $trx = getTrx();

                $transaction               = new Transaction();
                $transaction->user_id      = $this->user->id;
                $transaction->invest_id    = $this->invest->id;
                $transaction->amount       = $this->invest->total_invest_amount;
                $transaction->charge       = 0;
                $transaction->post_balance = $this->user->balance;
                $transaction->trx_type     = '+';
                $transaction->trx          = $trx;
                $transaction->remark       = 'capital_back';
                $transaction->details      = 'Capital back from ' . @$this->invest->property->title . " property investment";
                $transaction->save();

                notify($this->user, 'CAPITAL_BACK', [
                    'trx'          => $transaction->trx,
                    'amount'       => showAmount($this->invest->total_invest_amount),
                    'property_name'    => @$this->invest->property->title,
                    'post_balance' => showAmount($this->user->balance),
                ]);
            }

            $this->invest->get_profit_count += 1;
            $this->invest->total_profit     += $profitAmount;
            $this->invest->save();

            if ($this->property->profit_schedule == Status::PROFIT_ONETIME) {
                $this->invest->profit_status = Status::COMPLETED;
                $this->invest->save();
            } elseif ($this->property->profit_schedule == Status::PROFIT_REPEATED_TIME) {
                if ($this->invest->get_profit_count == $this->property->profit_repeat_time) {
                    $this->invest->profit_status = Status::COMPLETED;
                    $this->invest->save();
                }
            }

            if (($this->property->profit_schedule == Status::PROFIT_REPEATED_TIME || $this->property->profit_schedule == Status::PROFIT_LIFETIME) && $this->invest->profit_status != Status::COMPLETED) {
                $this->invest->next_profit_date = now()->addHours($this->property->profitScheduleTime->time);
                $this->invest->save();
            }

            //$this->user->balance += $profitAmount; //checkpoint where profit is cut off from bonus bal for independent withdrawals
            $this->user->save();

            $trx = getTrx();

            $transaction               = new Transaction();
            $transaction->user_id      = $this->user->id;
            $transaction->invest_id    = $this->invest->id;
            $transaction->profit_id    = $profit->id;
            $transaction->amount       = $profitAmount;
            $transaction->charge       = 0;
            $transaction->post_balance = $this->user->balance;
            $transaction->trx_type     = '+';
            $transaction->trx          = $trx;
            $transaction->remark       = 'profit';
            $transaction->details      = showAmount($profitAmount) . ' ' . $general->cur_text . ' profit from ' . @$this->invest->property->title . " property investment";
            $transaction->save();

            // Give Referral Commission if Enabled
            if ($general->profit_commission == Status::YES) {
                $commissionType = 'profit_commission';
                $this->referralCommission($commissionType, $profitAmount, $trx);
            }

            notify($this->user, 'PROFIT', [
                'trx'          => $transaction->trx,
                'amount'       => showAmount($profitAmount),
                'property_name'    => @$this->invest->property->title,
                'post_balance' => showAmount($this->user->balance),
            ]);
        }

        return $profitAmount;
    }

    protected function getProfitAmount($amount = 0)
    {
        if ($this->checkProfitType()) {
            if ($this->checkProfitAmountType()) {
                return $amount ? $amount : $this->property->auto_profit_distribution_amount;
            } else {
                return ($this->invest->total_invest_amount / 100) * ($amount ? $amount : $this->property->auto_profit_distribution_amount);
            }
        } else {
            if ($this->checkProfitAmountType()) {
                return $amount ? $amount : $this->property->profit_amount;
            } else {
                return ($this->invest->total_invest_amount / 100) * ($amount ? $amount : $this->property->profit_amount);
            }
        }
    }

    protected function checkProfitType()
    {
        return $this->property->profit_type == Status::PROFIT_TYPE_RANGE ? true : false;
    }

    protected function checkProfitAmountType()
    {
        return $this->property->profit_amount_type == Status::PROFIT_AMOUNT_TYPE_FIXED ? true : false;
    }

    protected function createLateFee($lateFee = 0)
    {
        if ($lateFee > 0) {

            $this->user->balance -= $lateFee;
            $this->user->save();

            $trx                       = getTrx();
            $transaction               = new Transaction();
            $transaction->user_id      = $this->user->id;
            $transaction->invest_id    = $this->invest->id;
            $transaction->amount       = $lateFee;
            $transaction->post_balance = $this->user->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Installment late fee on ' . $this->property->title . ' property investment';
            $transaction->trx          = $trx;
            $transaction->remark       = 'installment_late_fee';
            $transaction->save();
        }
    }

    public function referralCommission($commissionType, $amount, $trx = null)
    {
        $user      = $this->user;
        $levelInfo = Referral::where('commission_type', $commissionType)->get();
        $level     = 0;

        while (@$user->ref_by && $level < $levelInfo->count()) {
            $user = User::find($user->ref_by);
            $commission = ($levelInfo[$level]->percent / 100) * $amount;
            //$user->balance += $commission;            
            $user->referral_balance += $commission;
            $user->save();
            $level++;

            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $commission;
            $transaction->post_balance = $user->referral_balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Level ' . $level . ' Referral Commission From ' . $this->user->username . $commissionType;
            $transaction->trx          =  $trx ?? $this->trx;
            $transaction->remark       = $commissionType;
            $transaction->save();

            if ($commissionType == 'deposit_commission') {
                $comType = 'Deposit';
            } elseif ($commissionType == 'profit_commission') {
                $comType = 'Profit ';
            } elseif ($commissionType == 'rentals_commission') {
                $comType = 'Rentals ';
            } elseif ($commissionType == 'voucher_commission') {
                $comType = 'Voucher ';
            } elseif ($commissionType == 'thrift_commission') {
                $comType = 'Thrift ';
            } else {
                $comType = 'Registration';
            }

            notify($user, 'REFERRAL_COMMISSION', [
                'amount'       => showAmount($commission),
                'post_balance' => showAmount($user->balance),
                'trx'          => $this->trx,
                'level'        => ordinal($level),
                'type'         => $comType,
            ]);
        }
    }
    
    public function investReferralCommission($investCommissionType, $amount, $trx = null)
{
    $investCommissionTypeMapping = [
        'Bronze Member' => 'bronze_sales_invest_comm',
        'Silver Member' => 'silver_sales_invest_comm',
        'Gold Member'   => 'gold_sales_invest_comm',
    ];

    $buyer = $this->user;

    // Get the buyer's membership type and corresponding commission type
    $membershipType = $buyer->partnership_type;
    $investCommissionType = $investCommissionTypeMapping[$membershipType] ?? 'default_commission';

    $levelInfo = Referral::where('commission_type', $investCommissionType)->get();
    $level = 0;

    // Step 1: Give commission to the buyer
    if ($level < $levelInfo->count()) {
        $commission = ($levelInfo[$level]->percent / 100) * $amount;
        $buyer->referral_balance += $commission;
        $buyer->save();

        $transaction = new Transaction();
        $transaction->user_id = $buyer->id;
        $transaction->amount = $commission;
        $transaction->post_balance = $buyer->referral_balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Level 1 Investment Referral Commission From ' . $buyer->username;
        $transaction->trx = $trx ?? $this->trx;
        $transaction->remark = $investCommissionType;
        $transaction->save();

        $level++;
    }

    // Step 2: Loop through referrers for Level 2 and beyond
    $referrer = User::find($buyer->ref_by);
        while ($referrer && $level < $levelInfo->count()) {
            $refMembershipType = $referrer->partnership_type;
            $refCommissionType = $investCommissionTypeMapping[$refMembershipType] ?? 'default_commission';
    
            $levelInfo = Referral::where('commission_type', $refCommissionType)->get();
    
            if ($level < $levelInfo->count()) {
                $commission = ($levelInfo[$level]->percent / 100) * $amount;
                $referrer->referral_balance += $commission;
                $referrer->save();
    
                $transaction = new Transaction();
                $transaction->user_id = $referrer->id;
                $transaction->amount = $commission;
                $transaction->post_balance = $referrer->referral_balance;
                $transaction->charge = 0;
                $transaction->trx_type = '+';
                $transaction->details = 'Level ' . ($level + 1) . ' Investment Referral Commission From ' . $buyer->username;
                $transaction->trx = $trx ?? $this->trx;
                $transaction->remark = $refCommissionType;
                $transaction->save();
    
                $level++;
            }
    
            $referrer = User::find($referrer->ref_by);
        }
    }

    
    
    //foodCommunity registration referral comm starts here
    public function fdRegReferralCommission($commissionType, $amount, $trx = null)
    {
        $user      = $this->user;
        $levelInfo = Referral::where('commission_type', $commissionType)->get();
        $level     = 0;

        while (@$user->ref_by && $level < $levelInfo->count()) {
            $user = User::find($user->ref_by);
            $commission = ($levelInfo[$level]->percent / 100) * $amount;
            $user->referrals_sales_comm += $commission;
            $user->save();
            $level++;

            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $commission;
            $transaction->post_balance = $user->referrals_sales_comm;
            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Level ' . $level . ' Referral Commission From ' . $this->user->username . $commissionType;
            $transaction->trx          =  $trx ?? $this->trx;
            $transaction->remark       = $commissionType;
            $transaction->save();
        }
    }
    
    //foodCommunity referrer comm starts here
    public function foodComRefCommission($commissionType, $amount, $trx = null)
{
    $user = $this->user;
    $levelInfo = Referral::where('commission_type', $commissionType)->get();
    $level = 0;

    // Step 1: Give Level 1 commission to the owner of the account
    if ($level < $levelInfo->count()) {
        $shopMallCommission = ($levelInfo[$level]->percent / 100) * $amount;
        $user->direct_sales_comm += $shopMallCommission;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $shopMallCommission;
        $transaction->post_balance = $user->direct_sales_comm;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Level 1 Referral Commission From ' . $this->user->username . $commissionType;
        $transaction->trx = $trx ?? $this->trx;
        $transaction->remark = $commissionType;
        $transaction->save();

        $level++;
    }

    // Step 2: Loop through referrers for Level 2 and beyond
    while (@$user->ref_by && $level < $levelInfo->count()) {
        $user = User::find($user->ref_by);
        $shopMallCommission = ($levelInfo[$level]->percent / 100) * $amount;
        $user->referrals_sales_comm += $shopMallCommission;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $shopMallCommission;
        $transaction->post_balance = $user->referrals_sales_comm;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Level ' . ($level + 1) . ' Referral Commission From ' . $this->user->username . $commissionType;
        $transaction->trx = $trx ?? $this->trx;
        $transaction->remark = $commissionType;
        $transaction->save();
        $level++;
    }
}
//foodmall comm based on partnership
public function foodComRefPartnerComm($commissionType, $amount, $trx = null)
{
    $commissionTypeMapping = [
        'Basic Partner'   => 'bronze_sales_comm',
        'Bronze Partner'   => 'bronze_sales_comm',
        'Silver Partner'  => 'silver_sales_comm',
        'Gold Partner'    => 'gold_sales_comm',
        'Diamond Partner' => 'diamond_sales_comm',
    ];

    $user = $this->user;

    $levelInfo = Referral::where('commission_type', $commissionType)->get();
    $level = 0;

    // Step 1: Give Level 1 commission to the owner of the account
    if ($level < $levelInfo->count()) {
        $shopMallCommission = ($levelInfo[$level]->percent / 100) * $amount;
        $user->direct_sales_comm += $shopMallCommission;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $shopMallCommission;
        $transaction->post_balance = $user->direct_sales_comm;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Level 1 Referral Commission From ' . $this->user->username . $commissionType;
        $transaction->trx = $trx ?? $this->trx;
        $transaction->remark = $commissionType;
        $transaction->save();

        $level++;
    }

    // Step 2: Loop through referrers for Level 2 and beyond
    while (@$user->ref_by && $level < $levelInfo->count()) {
        $user = User::find($user->ref_by);
        $partnershipType = $user->partnership_type;
        $commissionType = $commissionTypeMapping[$partnershipType] ?? 'default_commission';

        $levelInfo = Referral::where('commission_type', $commissionType)->get();

        if ($level < $levelInfo->count()) {
            $shopMallCommission = ($levelInfo[$level]->percent / 100) * $amount;
            $user->referrals_sales_comm += $shopMallCommission;
            $user->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $shopMallCommission;
            $transaction->post_balance = $user->referrals_sales_comm;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->details = 'Level ' . ($level + 1) . ' Referral Commission From ' . $this->user->username . $commissionType;
            $transaction->trx = $trx ?? $this->trx;
            $transaction->remark = $commissionType;
            $transaction->save();

            $level++;
        }
    }

}
}
