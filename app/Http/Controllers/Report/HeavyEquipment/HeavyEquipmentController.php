<?php

namespace App\Http\Controllers\Report\HeavyEquipment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeavyEquipmentController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.heavy-equipment.index');
    }
}
