<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Property extends Model
{
    use GlobalStatus, Searchable;

    protected $casts = [
        'amenities' => 'array',
        'keywords'   => 'array',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function propertyGallery()
    {
        return $this->hasMany(PropertyGallery::class);
    }

    public function invests()
    {
        return $this->hasMany(Invest::class);
    }

    public function profitScheduleTime()
    {
        return $this->belongsTo(TimeSetting::class, 'profit_schedule_period', 'id');
    }

    public function installmentDuration()
    {
        return $this->belongsTo(TimeSetting::class, 'installment_duration', 'id');
    }

    public function scopeRunning($query)
    {
        return $query->where('invest_status', Status::RUNNING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('invest_status', Status::COMPLETED);
    }
    public function scopeInvested($query)
    {
        return $query->whereHas('invests');
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE)->where('complete_step', 2);
    }
    public function investmentStatus(): Attribute
    {
        return new Attribute(function () {
            if ($this->invest_status == Status::COMPLETED) {
                return '<span class="badge badge--success">' . trans('Completed') . '</span>';
            } elseif ($this->invest_status == Status::RUNNING) {
                return '<span class="badge badge--primary">' . trans('Running') . '</span>';
            } else {
                return '<span class="badge badge--warning">' . trans('No Investment') . '</span>';
            }
        });
    }

    
    public function capitalBackStatusBadge(): Attribute
    {
        return new Attribute(function () {
            if ($this->is_capital_back == Status::CAPITAL_BACK_YES) {
                return '<span class="badge badge--success">' . trans('Yes') . '</span>';
            } else {
                return '<span><span class="badge badge--warning">' . trans('No') . '</span></span>';
            }
        });
    }

    public function isFeaturedStatus(): Attribute
    {
        return new Attribute(function () {
            if ($this->is_featured == Status::YES) {
                return '<span class="badge badge--success">' . trans('Yes') . '</span>';
            } else {
                return '<span><span class="badge badge--warning">' . trans('No') . '</span></span>';
            }
        });
    }

    public function getProfit(): Attribute
    {
        return new Attribute(function () {
            $currency = gs('cur_sym');
            if ($this->profit_type == Status::PROFIT_TYPE_FIXED) {
                if ($this->profit_amount_type == Status::PROFIT_AMOUNT_TYPE_FIXED) {
                    return $currency . showAmount($this->profit_amount);
                } else {
                    return getAmount(@$this->profit_amount) . trans('%');
                }
            } else {
                if ($this->profit_amount_type == Status::PROFIT_AMOUNT_TYPE_FIXED) {
                    return $currency . showAmount(@$this->minimum_profit_amount) . ' - ' . $currency . showAmount(@$this->maximum_profit_amount);
                } else {
                    return getAmount(@$this->minimum_profit_amount) . ' - ' . getAmount(@$this->maximum_profit_amount) . trans('%');
                }
            }
        });
    }

    public function getProfitType(): Attribute
    {
        return new Attribute(function () {
            if ($this->profit_type == Status::PROFIT_TYPE_FIXED) {
                return trans('Fixed');
            } else {
                return trans('Range');
            }
        });
    }

    public function getInvestmentType(): Attribute
    {
        return new Attribute(function () {
            if ($this->invest_type == Status::INVEST_TYPE_INSTALLMENT) {
                return trans('Installment');
            } else {
                return trans('Onetime Investment');
            }
        });
    }

    public function getProfitSchedule(): Attribute
    {
        return new Attribute(function () {
            if ($this->profit_schedule == Status::PROFIT_LIFETIME) {
                return trans('Lifetime') . ' (' . trans($this->profitScheduleTime->name) . ')';
            } elseif ($this->profit_schedule == Status::PROFIT_REPEATED_TIME) {
                return trans('Repeat') . ' (' . trans($this->profitScheduleTime->name) . ')';
            } else {
                return trans('Onetime');
            }
        });
    }

    public function getCapitalBackStatus(): Attribute
    {
        return new Attribute(function () {
            if ($this->is_capital_back == Status::CAPITAL_BACK_YES) {
                return trans('Yes');
            } else {
                return trans('No');
            }
        });
    }

    public function investProgress(): Attribute
    {
        $investAmount = $this->invested_amount ?? 0;
        $goalAmount   = $this->goal_amount ?? 0;

        if ($investAmount > 0 && $goalAmount > 0) {
            $progress = ($investAmount * 100) / @$goalAmount;
        } else {
            $progress = 0;
        }

        return new Attribute(function ()  use ($progress) {
            return $progress;
        });
    }
}
