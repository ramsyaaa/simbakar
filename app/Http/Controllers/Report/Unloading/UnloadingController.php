<?php

namespace App\Http\Controllers\Report\Unloading;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnloadingController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.unloading.index');
    }
}
