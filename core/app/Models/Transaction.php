<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Searchable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invest()
    {
        return $this->belongsTo(Invest::class);
    }

    public function profit()
    {
        return $this->belongsTo(Profit::class);
    }
}
