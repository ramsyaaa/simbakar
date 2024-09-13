<?php

namespace App\Http\Controllers\InitialData;

use App\BiomassaReceiptPlan;
use App\Http\Controllers\Controller;
use App\Models\SettingBpb;
use Illuminate\Http\Request;

class BiomassaReceiptController extends Controller
{
    public function index(Request $request){
        $data['year'] = $request->input('year') ? $request->input('year') : date('Y');
        $data['years'] = SettingBpb::get();
        if ($data['year']) {
            $data['biomassa_receipt_plan'] = BiomassaReceiptPlan::where('year',$data['year'])->orderBy('year','desc')->first();
        }else{
            $data['biomassa_receipt_plan'] = BiomassaReceiptPlan::orderBy('year','desc')->first();
        }
        return view('initial-data.biomassa-receipt-plans.index', $data);
    }

    public function create(Request $request){

        return view('initial-data.biomassa-receipt-plans.create');
    }

    public function edit(Request $request, $uuid){

        $data['biomassa_receipt_plan'] = BiomassaReceiptPlan::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.biomassa-receipt-plans.edit', $data);
    }

    public function  store(Request $request){

        BiomassaReceiptPlan::create([
            'setting_bpb_uuid' => 1,
            'planning_january' => $request->planning_january,
            'planning_february' => $request->planning_february,
            'planning_march' => $request->planning_march,
            'planning_april' => $request->planning_april,
            'planning_may' => $request->planning_may,
            'planning_june' => $request->planning_june,
            'planning_july' => $request->planning_july,
            'planning_august' => $request->planning_august,
            'planning_september' => $request->planning_september,
            'planning_october' => $request->planning_october,
            'planning_november' => $request->planning_november,
            'planning_december' => $request->planning_december,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.biomassa-receipt-plan.index')->with('success', 'Data berhasil dibuat.');
    }
    public function  update(Request $request, $uuid){
        $request->validate([
            'planning_january' => 'nullable|numeric',
            'planning_february' => 'nullable|numeric',
            'planning_march' => 'nullable|numeric',
            'planning_april' => 'nullable|numeric',
            'planning_may' => 'nullable|numeric',
            'planning_june' => 'nullable|numeric',
            'planning_july' => 'nullable|numeric',
            'planning_august' => 'nullable|numeric',
            'planning_september' => 'nullable|numeric',
            'planning_october' => 'nullable|numeric',
            'planning_november' => 'nullable|numeric',
            'planning_december' => 'nullable|numeric',
        ]);

        BiomassaReceiptPlan::where('uuid', $uuid)->update([
            'planning_january' => $request->planning_january,
            'planning_february' => $request->planning_february,
            'planning_march' => $request->planning_march,
            'planning_april' => $request->planning_april,
            'planning_may' => $request->planning_may,
            'planning_june' => $request->planning_june,
            'planning_july' => $request->planning_july,
            'planning_august' => $request->planning_august,
            'planning_september' => $request->planning_september,
            'planning_october' => $request->planning_october,
            'planning_november' => $request->planning_november,
            'planning_december' => $request->planning_december,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.biomassa-receipt-plan.index')->with('success', 'Data berhasil diubah.');
    }
}
