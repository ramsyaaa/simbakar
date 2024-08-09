<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\BbmReceiptPlan;
use App\Models\SettingBpb;
use Illuminate\Http\Request;

class BbmReceiptPlanController extends Controller
{
    public function index(Request $request){
        $data['year'] = $request->input('year');
        $data['years'] = SettingBpb::get();
        if ($data['year']) {
            $data['bbm_receipt_plans'] = BbmReceiptPlan::where('year',$data['year'])->orderBy('year','desc')->get()->groupBy('type');
        }else{
            $data['bbm_receipt_plans'] = BbmReceiptPlan::orderBy('year','desc')->get()->groupBy('type');
        }
        return view('initial-data.bbm-receipt-plans.index', $data);
    }

    public function create(Request $request){

        return view('initial-data.bbm-receipt-plans.create');
    }

    public function edit(Request $request, $uuid){
        $data['bbm_receipt_plan'] = BbmReceiptPlan::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.bbm-receipt-plans.edit', $data);
    }

    public function  store(Request $request){

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

        BbmReceiptPlan::create([
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
            'type' => $request->type,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.bbm-receipt-plan.index')->with('success', 'Data berhasil ditambah.');
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

        BbmReceiptPlan::where('uuid', $uuid)->update([
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
            'type' => $request->type,
            'year' => $request->year,
        ]);

        return redirect()->route('initial-data.bbm-receipt-plan.index')->with('success', 'Data berhasil diupdate.');
    }
}
