<?php

namespace App\Http\Controllers\Report\Performance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.performance.index');
    }
}
