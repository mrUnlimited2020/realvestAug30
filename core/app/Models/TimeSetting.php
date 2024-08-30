<?php

namespace App\Models;
  

use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TimeSetting extends Model
{
    use GlobalStatus, Searchable;

    public function getTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->time . ' ' . $this->name,
        );
    }
}
