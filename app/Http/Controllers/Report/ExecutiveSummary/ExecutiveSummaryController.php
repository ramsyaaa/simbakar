<?php

namespace App\Http\Controllers\Report\ExecutiveSummary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExecutiveSummaryController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.executive-summary.index');
    }
}
