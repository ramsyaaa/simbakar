<?php

namespace App\Http\Controllers\Report\Receipt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.receipt.index');
    }
}
