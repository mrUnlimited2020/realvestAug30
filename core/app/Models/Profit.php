<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    use GlobalStatus, Searchable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invest()
    {
        return $this->belongsTo(Invest::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', Status::PROFIT_SUCCESS);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::PROFIT_PENDING);
    }
}
