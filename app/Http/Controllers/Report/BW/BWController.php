<?php

namespace App\Http\Controllers\Report\BW;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BWController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.bw.index');
    }
}
