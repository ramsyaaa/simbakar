<?php

namespace App\Http\Controllers\Report\CoalQuality;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoalQualityController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.coal-quality.index');
    }
}
