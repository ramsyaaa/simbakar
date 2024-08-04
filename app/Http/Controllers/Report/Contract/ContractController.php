<?php

namespace App\Http\Controllers\Report\Contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.contracts.index');
    }
}
