<?php

namespace App\Http\Controllers\Report\ShipMonitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShipMonitoringController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.ship-monitoring.index');
    }
}
