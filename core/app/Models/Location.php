<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use GlobalStatus, Searchable;

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
