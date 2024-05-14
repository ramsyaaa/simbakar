<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\CoalReceiptPlan;
use App\Models\SettingBpb;
use Illuminate\Http\Request;

class CoalReceiptPlanController extends Controller
{
    public function index(Request $request){
        $data['year'] = $request->input('year');
        $data['years'] = SettingBpb::get();
        if ($data['year']) {
            $data['coal_receipt_plan'] = CoalReceiptPlan::where([
                'setting_bpb_uuid' => $data['year'],
            ])->first();
            $data['bpb'] = SettingBpb::where(['uuid' => $data['year']])->first();
        }else{
            $data['coal_receipt_plan'] = CoalReceiptPlan::latest()->first();
            $data['bpb'] = SettingBpb::where(['uuid' => $data['coal_receipt_plan']->setting_bpb_uuid])->first();
        }
        return view('initial-data.coal-receipt-plans.index', $data);
    }

    public function edit(Request $request, $uuid){
        $data['coal_receipt_plan'] = CoalReceiptPlan::where([
            'uuid' => $uuid,
        ])->first();
        return view('initial-data.coal-receipt-plans.edit', $data);
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

        CoalReceiptPlan::where('uuid', $uuid)->update([
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
        ]);

        return redirect()->back()->with('success', 'Data berhasil diupdate.');
    }
}
