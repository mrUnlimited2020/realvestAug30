<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\User;
use App\Models\Invest;
use App\Models\Profit;
use App\Models\Deposit;
use App\Models\Wallet;
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
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function home()
    {
        $pageTitle                     = 'Dashboard';
        $user                          = auth()->user();
        $paidAmountSum                 = Invest::where('user_id', $user->id)->sum('paid_amount');
        $registrationFeeSum            = Invest::where('user_id', $user->id)->sum('bronze_mbmr_reg_fee');
        $totalAfterFees                = $paidAmountSum - $registrationFeeSum;
        $totalInvestments              = Invest::where('user_id', $user->id)->count();
        $transactionWallet             = User::where('id', $user->id)->first()->balance;
        $userId                        = $user->id;
        // Only recalculate if the wallet hasn't been updated recently
        if (!$user->profit_wallet_last_updated) {
            $user->profit_wallet = Invest::where('user_id', $user->id)
                ->where('invest_status', Status::COMPLETED)
                ->sum('total_profit');
            $user->profit_wallet_last_updated = now(); // Set the timestamp
            $user->save();
        }
        
        //the starting ID is from 18 downwards
        $propertyId                    = 18;
        $teamSalesVolume               = function($userId, $propertyId){
            $directReferrals           = User::where('ref_by', $userId)->pluck('id')->toArray(); 

            $secondLevelReferrals      = User::whereIn('ref_by', $directReferrals)->pluck('id')->toArray();

            $thirdLevelReferrals       = User::whereIn('ref_by', $secondLevelReferrals)->pluck('id')->toArray();

            $allUserIds                = array_merge($directReferrals, $secondLevelReferrals, $thirdLevelReferrals); //[$userId], removed due to it shows already for direct sales volume 

            // Calculate the total amount for investments in properties with IDs lesser than or equal to $propertyId
            $totalAmount               = Invest::whereIn('user_id', $allUserIds)
                ->whereHas('property', function($query) use ($propertyId) {
                    $query->where('id', '<=', $propertyId);
                })
                ->sum('paid_amount')*0.005;//note: this *0.005 was added to stepdown the amt
            
            // Return the total amount formatted to 2 decimal places
            $formattedAmount           = number_format($totalAmount, 2, '.', ',');
            return $formattedAmount;
        };

        $formattedAmountTeam       = $teamSalesVolume($userId, $propertyId);
        $totalAmountTeam           = floatval(str_replace(',', '', $formattedAmountTeam)); // Convert formattedAmountTeam to float for comparison

        //Direct Sales volume
        $directSalesVolume             = function($userId, $propertyId){
            $totalAmount               = Invest::where('user_id', $userId)
                ->whereHas('property', function($query) use ($propertyId) {
                    $query->where('id', '<=', $propertyId);
                })
                ->sum('paid_amount');
            $formattedAmount           = number_format($totalAmount, 2, '.', ',');
            return $formattedAmount;
        };

        $formattedAmountDirect       = $directSalesVolume($userId, $propertyId);
        $totalAmountDirect           = floatval(str_replace(',', '', $formattedAmountDirect)); // Convert formattedAmountDirect to float for comparison

        // Define the DSV and TSV variables
        $DSV = $totalAmountDirect;
        $TSV = $totalAmountTeam;
        $user = User::find($userId);

        if ($user) {
            $partnershipType = $user->partnership_type ?? 'Bsaic Member';
            $PST = 0;
            switch ($partnershipType) {
                case 'Basic Member':
                case 'Bronze Member':
                    $PST = 0.002 * $DSV;
                    break;
                case 'Silver Member':
                    $PST = 0.002 * $DSV + 0.001 * $TSV;
                    break;
                case 'Gold Member':
                    $PST = 0.002 * $DSV + 0.002 * $TSV;
                    break;
                default:
                    exit;
            }
            $pt = number_format($PST, 2);
        }
        else {
            $pt =  '0.00'; 
        }

        $widget['profit_sharing_token']= $pt;
        $widget['direct_sales_volume'] = $directSalesVolume($userId, $propertyId);
        
        $widget['team_sales_volume']   = $teamSalesVolume($userId, $propertyId);
        $widget['total_property']      = $totalInvestments;
        $widget['balance']             = $user->balance;
        $widget['trx_wallet']          = number_format($transactionWallet, 2); // 2 decimal places
        $widget['total_deposit']       = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw']      = Withdrawal::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_profit']        = $user->profit_wallet;
        $widget['referral']            = User::where('ref_by', $user->id)->count();
        $widget['referral_balance']    = $user->referral_balance;
        $widget['psq_invest']          = Invest::where('user_id', $user->id)->sum('psq_invest');
        $widget['thrift_invest']       = Invest::where('user_id', $user->id)->sum('thrift_invest');
        $widget['v_landlord_invest']   = Invest::where('user_id', $user->id)->sum('v_landlord_invest');
        $widget['total_after_fees']    = $totalAfterFees;
        $widget['total_ticket']        = SupportTicket::where('user_id', $user->id)->count();
        $nextProfitSchedule            = Invest::where('user_id', $user->id)->with('property')->where('profit_status', Status::RUNNING)->orderBy('next_profit_date')->first();

        $nextInstallment               = Installment::whereHas('invest', function ($invest) use ($user) {
            $invest->where('user_id', $user->id);
        })->where('status', Status::INSTALLMENT_PENDING)->orderBy('next_time')->with(['invest'])->first();


        $trxReport['date']             = collect([]);
        $investTrx                     = Transaction::where('user_id', $user->id)
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
        $directSalesComm               = $user->direct_sales_comm;
        $referralsSalesComm            = $user->referrals_sales_comm;
        $totalInvestments              = Invest::where('user_id', $user->id)->count();
        $userId                        = $user->id;
        
        // Define the starting ID
        $foodCommPropertyId = 19;

        $foodCommTeamSalesVolume = function($userId, $foodCommPropertyId) {
            $directReferrals = User::where('ref_by', $userId)->pluck('id')->toArray();

            $secondLevelReferrals = User::whereIn('ref_by', $directReferrals)->pluck('id')->toArray();

            $thirdLevelReferrals = User::whereIn('ref_by', $secondLevelReferrals)->pluck('id')->toArray();

            $allUserIds = array_merge($directReferrals, $secondLevelReferrals, $thirdLevelReferrals); //[$userId], removed due to it shows already for direct sales volume
            
            // Calculate the total amount for investments in properties with IDs greater than or equal to $foodCommPropertyId
            $totalAmountFoodComm = Invest::whereIn('user_id', $allUserIds)
                ->whereHas('property', function($query) use ($foodCommPropertyId) {
                    $query->where('id', '>=', $foodCommPropertyId);
                })
                ->sum('paid_amount')*0.005; //note: this *0.005 was added to stepdown the amt
            
            // Return the total amount formatted to 2 decimal places
            return number_format($totalAmountFoodComm, 2, '.', '');
        };
        
        $foodCommformattedAmountTeam       = $foodCommTeamSalesVolume($userId, $foodCommPropertyId);
        $totalAmountFoodCommTeam           = floatval(str_replace(',', '', $foodCommformattedAmountTeam)); // Convert foodCommformattedAmountTeam to float for comparison
        
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
            if ($totalAmountFoodCommTeam >= $threshold) {
                $profit = $profits[$level];
                $scash['total'] = $profit;
                $scash['part1'] = $profit * 0.30 / 500;
                $scash['part2'] = $profit * 0.70;
            }
        };
        
        $foodCommDirectSalesVolume     = function($userId, $foodCommPropertyId){
            $totalAmountFoodComm               = Invest::where('user_id', $userId)
                ->whereHas('property', function($query) use ($foodCommPropertyId) {
                    $query->where('id', '>=', $foodCommPropertyId);
                })
                ->sum('paid_amount');
            return number_format($totalAmountFoodComm, 2, '.', ',');
        };
        
        
        $foodCommformattedAmountDirect       = $foodCommDirectSalesVolume($userId, $foodCommPropertyId);
        $totalAmountFoodCommDirect           = floatval(str_replace(',', '', $foodCommformattedAmountDirect)); // Convert foodCommformattedAmountDirect to float for comparison
        
        $DSV = $totalAmountFoodCommDirect;
        $TSV = $totalAmountFoodCommTeam;
        $user = User::find($userId);

        if ($user) {
            $partnershipType = $user->partnership_type ?? 'Bronze Member';

            $PSTofDSV = 0;
            $PSTofTSV = 0;
            
            switch ($partnershipType) {
                case 'Basic Member':
                    $PSTofDSV = 0.001 * $DSV;
                    $PSTofTSV = 0.001 * $TSV;
                    break;
                case 'Bronze Member':
                    $PSTofDSV = 0.001 * $DSV;
                    $PSTofTSV = 0.001 * $TSV;
                    break;
                case 'Silver Member':
                    $PSTofDSV = 0.002 * $DSV;
                    $PSTofTSV = 0.002 * $TSV;                    
                    break;
                case 'Gold Member':
                    $PSTofTSV = 0.003 * $TSV;                    
                    $PSTofDSV = 0.003 * $DSV;
                    break;
                default:
                    exit;
            }
            
            $pt1 = number_format($PSTofDSV, 2);
            $pt2 = number_format($PSTofTSV, 2);
        }
        else {
            $pt1 = '0.00'; // Default value if $user is not defined
            $pt2 = '0.00'; // Default value if $user is not defined

        }

        $widget['pst_of_dsv']          = $pt1;
        $widget['pst_of_tsv']          = $pt2;
        $widget['total_property']      = $totalInvestments;
        $widget['balance']             = $user->balance;
        $widget['total_deposit']       = Deposit::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_withdraw']      = Withdrawal::where('user_id', $user->id)->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
        $widget['total_profit']        = Invest::where('user_id', $user->id)->where('invest_status', Status::COMPLETED)->sum('total_profit');
        $widget['referral']            = User::where('ref_by', $user->id)->count();
        $widget['direct_sales_comm']   = $directSalesComm;
        $widget['referrals_sales_comm'] = $referralsSalesComm;
        $widget['sales_balance']        = $referralsSalesComm + $directSalesComm;
        $widget['food_comm_team_sales_volume']   = $foodCommTeamSalesVolume($userId, $foodCommPropertyId);
        $widget['food_comm_user_scash']          = $scash['part1'];
        $widget['food_comm_coy_scash']           = $scash['part2'];
        $widget['food_comm_direct_sales_volume']   = $foodCommDirectSalesVolume($userId, $foodCommPropertyId);

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

    // Method to show the conversion form
    public function showConvertForm()
    {
        $pageTitle = 'Convert Balance';
        return view($this->activeTemplate . 'user.convert', compact('pageTitle'));
    }
    
    public function trxConvert(Request $request){
        $user = auth()->user();
        $request->validate([
            'amount' => 'numeric|min:0',
        ]);

        $amount = $request->input('amount');
        
        if ($user->balance < $amount) {
            $notify[] = ['error', 'You have Insufficient balance'];
            return redirect()->route('user.convert')->withNotify($notify);
        }
        
        $user->balance -= $amount;
        $user->balance += $amount;
        $user->save();
        $notify[] = ['success', 'Balance Converted Successfully!'];
        
        $trx = getTrx();
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->charge       = 0;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '-';
        $transaction->trx          = $trx;
        $transaction->remark       = 'balance conversion';
        $transaction->details      = showAmount($amount) . ' converted from bonus balance to transaction wallet';
        $transaction->save();
        
        return redirect()->route('user.home')->withNotify($notify);
    }

    public function showTransferForm(){
        $pageTitle = 'Transfer Transaction Wallet';
        return view($this->activeTemplate . 'user.transfer', compact('pageTitle'));    
    }
    
    public function trxTransfer(Request $request){
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'amount' => 'required|numeric|min:0'
        ]);

        $user = auth()->user();
        $recipient = User::where('username', $request->input('username'))->first(); // The recipient
        $amount = $request->input('amount');
        
        // Check if the recipient is the same as the sender
        if ($recipient->id == $user->id) {
            $notify[] = ['error', 'Oga sir, You cannot transfer balance to yourself!'];
            return back()->withNotify($notify);
        }

        if ($user->balance < $amount) {
            $notify[] = ['error', 'Insufficient transaction wallet'];
            return redirect()->route('user.transfer')->withNotify($notify);
        }
        // Deduct amount from sender
        $user->balance -= $amount;
        $user->save();

        // Add amount to recipient
        $recipient->balance += $amount;
        $recipient->save();
        
        // transaction record for sender
        $trx = getTrx(); // Function to generate a unique transaction ID
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $amount; 
        $transaction->charge = 0;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->trx = $trx;
        $transaction->remark = 'Balance transfer to ' . $recipient->username;
        $transaction->details = 'N' . showAmount($amount) . ' transferred to ' . $recipient->username;
        $transaction->save();

        // transaction record for recipient
        $transaction = new Transaction();
        $transaction->user_id = $recipient->id;
        $transaction->amount = $amount; // Positive for credit
        $transaction->charge = 0;
        $transaction->post_balance = $recipient->balance;
        $transaction->trx_type = '+';
        $transaction->trx = $trx;
        $transaction->remark = 'Balance transfer from ' . $user->username;
        $transaction->details = 'N' . showAmount($amount) . ' received from ' . $user->username;
        $transaction->save();
        $notify[] = ['success', 'Transaction wallet Transfered Successfully!'];
        return redirect()->route('user.home')->withNotify($notify);   
    }
    
    //To organize Stockist dashboard
    public function goodsInStock(){
        $pageTitle = 'Goods In Stock';
        // Get the list of referred users using Eloquent 
        $referredUserIds = User::where('ref_by', Auth::id())
            ->pluck('id'); 
        
        // Get investments for referred users and join with users table to get additional details
        $orders = Invest::whereIn('user_id', $referredUserIds) 
            ->join('users', 'invests.user_id', '=', 'users.id') 
            ->select('invests.investment_id','invests.property_name', 'invests.total_invest_amount', 'invests.created_at', 'users.username as buyer_name') 
            ->get();
        return view($this->activeTemplate . 'user.goodsinstock', compact('pageTitle', 'orders'));    
    }
    public function orderDetails(Request $request){
        $pageTitle = 'Order Details';
        
        // Get the list of referred users using Eloquent 
        $referredUserIds = User::where('ref_by', Auth::id())
            ->pluck('id'); 
        
        // Get investments for referred users and join with users table to get additional details
        $orders = Invest::whereIn('user_id', $referredUserIds) 
            ->join('users', 'invests.user_id', '=', 'users.id') 
            ->join('properties', 'invests.property_id', '=', 'properties.id') // Join with properties table
            ->select('invests.investment_id', 'invests.total_invest_amount', 'invests.created_at', 'users.username as buyer_name', 'properties.title as property_title')
            ->with('method');
            
        if ($request->search) {
            $orders = $orders->where('invests.investment_id', $request->search);
        }
        // Order and paginate the results 
        $orders = $orders->orderBy('invests.id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.orderdetails', compact('pageTitle', 'orders'));    
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
