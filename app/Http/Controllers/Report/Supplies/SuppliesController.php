<?php

namespace App\Http\Controllers\Report\Supplies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuppliesController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.supplies.index');
    }
}
