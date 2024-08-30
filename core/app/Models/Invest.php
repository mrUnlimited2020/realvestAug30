<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Invest extends Model
{
    use GlobalStatus, Searchable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function scopeRunning($query)
    {
        $query->where('invest_status', Status::RUNNING);
    }

    public function scopeCompleted($query)
    {

        $query->where('invest_status', Status::COMPLETED);
    }

    public function investStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->invest_status == Status::RUNNING) {
                $html = '<span class="badge badge--primary">' . trans('Running') . '</span>';
            } elseif ($this->invest_status == Status::COMPLETED) {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            }
            return $html;
        });
    }
    public function profitStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->profit_status == Status::RUNNING) {
                $html = '<span class="badge badge--primary">' . trans('Running') . '</span>';
            } elseif ($this->profit_status == Status::COMPLETED) {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            } elseif ($this->profit_status == Status::INVESTMENT_RUNNING) {
                $html = '<span class="badge badge--warning">' . trans('Investment Running') . '</span>';
            }
            return $html;
        });
    }
}
