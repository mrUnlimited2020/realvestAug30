<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invest;
use App\Models\Profit;
use App\Models\CronJob;
use App\Lib\CurlRequest;
use App\Constants\Status;
use App\Models\CronJobLog;
use App\Lib\PropertyInvest;

class CronController extends Controller
{
    private function profit()
    {
        try {
            $invests = Invest::where('invest_status', Status::COMPLETED)
                ->where('profit_status', Status::RUNNING)
                ->whereDate('next_profit_date', '<=', now())
                ->with(['property', 'property.profitScheduleTime', 'user'])
                ->get();

            foreach ($invests as $invest) {
                $user     = $invest->user;
                $property = $invest->property;

                $profitAmount = null;

                $profit = Profit::pending()->where('invest_id', $invest->id)->first();
                if ($property->profit_schedule == Status::PROFIT_ONETIME && @$profit) {
                    continue;
                }

                $profit              = new Profit();
                $profit->user_id     = $invest->user_id;
                $profit->property_id = $invest->property_id;
                $profit->invest_id   = $invest->id;
                $profit->save();

                if ($property->profit_distribution == Status::PROFIT_DISTRIBUTION_AUTO) {
                    $propertyInvest = new PropertyInvest($property, $invest, user: $user);
                    $profitAmount   = $propertyInvest->calProfit($profit);

                    $profit->amount = $profitAmount;
                    $profit->status = Status::PROFIT_SUCCESS;
                } else {
                    $profit->amount = 0;
                    $profit->status = Status::PROFIT_PENDING;

                    if ($property->profit_schedule == Status::PROFIT_REPEATED_TIME || $property->profit_schedule == Status::PROFIT_LIFETIME) {
                        $invest->next_profit_date = now()->addHours($property->profitScheduleTime->time);
                        $invest->save();
                    }
                }

                $profit->save();
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    private function installment()
    {
        try {
            $invests = Invest::where('invest_status', Status::RUNNING)->with(['user', 'property', 'installments' => function ($q) {
                $q->where('next_time', '<=', Carbon::parse(now()))->where('status', Status::INSTALLMENT_PENDING);
            }])->get();

            foreach ($invests as $invest) {
                foreach ($invest->installments as $installment) {
                    if (($invest->user->balance < $invest->per_installment_amount) && ($installment->late_fee <= 0) && (Carbon::parse(($installment->next_time))->toDateString() < Carbon::parse()->today()->toDateString())) {
                        $installment->late_fee +=  $invest->property->installment_late_fee;
                    } elseif ($invest->user->balance > ($invest->per_installment_amount + $installment->late_fee)) {
                        $installment->status = Status::INSTALLMENT_SUCCESS;
                        $installment->paid_time = today();

                        $propertyInvest = new PropertyInvest($invest->property, $invest, $installment, $invest->user);
                        $propertyInvest->invest($invest->per_installment_amount, $installment->late_fee);
                    }
                    $installment->save();
                }
            }
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');
        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', 1);
        }

        $crons = $crons->get();

        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds($cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }
}
