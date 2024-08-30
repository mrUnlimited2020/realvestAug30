<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Installment extends Model
{
    use Searchable;
    public function invest()
    {
        return $this->belongsTo(Invest::class);
    }

    public function installmentStatusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::INSTALLMENT_PENDING) {
                $html = '<span class="badge badge--primary">' . trans('Due') . '</span>';
            } elseif ($this->status == Status::INSTALLMENT_SUCCESS) {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            }
            return $html;
        });
    }
}
