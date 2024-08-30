<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeSetting;
use App\Traits\Crud;

class TimeSettingController extends Controller
{
    use Crud;

    protected $title         = 'Time Settings';
    protected $model         = TimeSetting::class;
    protected $view          = 'admin.time.';
    protected $searchable    = ['name', 'time'];
    protected $operationFor  = 'Time';


    public function __construct()
    {
        $this->orderByColumn = "time";
        $this->orderByValue  = "ASC";
    }
}
