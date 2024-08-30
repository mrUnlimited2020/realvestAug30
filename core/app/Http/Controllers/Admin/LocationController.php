<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Traits\Crud;

class LocationController extends Controller
{
    protected $title        = 'All Location';
    protected $model        = Location::class;
    protected $view         = 'admin.location.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Location';

    use Crud;

    public function __construct()
    {
        $this->hasImage = true;
    }
}
