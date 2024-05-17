<?php

namespace App\Http\Controllers\InitialData;

use App\Http\Controllers\Controller;
use App\Models\BbmReceiptPlan;
use App\Models\CoalReceiptPlan;
use App\Models\ConsumptionPlan;
use App\Models\ElectricityProduction;
use App\Models\SettingBpb;
use App\Models\YearStartData;
use Illuminate\Http\Request;

class SettingBpbController extends Controller
{
    public function index(Request $request){
        $query = SettingBpb::query();

        $data['bpbs'] = $query->paginate(10);
        $data['bpbs']->appends(request()->query());
        return view('initial-data.bpbs.index', $data);
    }

    public function create(){
        return view('initial-data.bpbs.create');
    }

    public function store(Request $request){
        $request->validate([
            'year' => 'required',
            'last_bpb_coal' => 'required',
            'last_bpb_solar' => 'required',
            'last_bpb_residu' => 'required',
        ], [
            'year.required' => 'Pemasok wajib diisi.',
            'last_bpb_coal.required' => 'BPB terakhir batubara wajib diisi.',
            'last_bpb_solar.required' => 'BPB terakhir solar wajib diisi.',
            'last_bpb_residu.required' => 'BPB terakhir residu wajib diisi.',
        ]);

        $setting_bpb = SettingBpb::create([
            'year' => $request->year,
            'last_bpb_coal' => $request->last_bpb_coal,
            'last_bpb_solar' => $request->last_bpb_solar,
            'last_bpb_residu' => $request->last_bpb_residu,
        ]);

        ElectricityProduction::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
        ]);
        YearStartData::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'batubara'
        ]);
        YearStartData::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'solar'
        ]);
        YearStartData::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'residu'
        ]);
        CoalReceiptPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
        ]);
        ConsumptionPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'batubara'
        ]);
        ConsumptionPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'solar'
        ]);
        ConsumptionPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'residu'
        ]);
        BbmReceiptPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'solar'
        ]);
        BbmReceiptPlan::create([
            'setting_bpb_uuid' => $setting_bpb->uuid,
            'type' => 'residu'
        ]);

        return redirect(route('initial-data.settings-bpb.index'))->with('success', 'Data baru berhasil dibuat.');
    }

    public function destroy($uuid){
        SettingBpb::where([
            'uuid' => $uuid,
        ])->delete();

        ElectricityProduction::where([
            'setting_bpb_uuid' => $uuid,
        ])->delete();
        YearStartData::where([
            'setting_bpb_uuid' => $uuid,
        ])->delete();
        CoalReceiptPlan::where([
            'setting_bpb_uuid' => $uuid,
        ])->delete();
        ConsumptionPlan::where([
            'setting_bpb_uuid' => $uuid,
        ])->delete();
        BbmReceiptPlan::where([
            'setting_bpb_uuid' => $uuid,
        ])->delete();

        return redirect(route('initial-data.settings-bpb.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['bpb'] = SettingBpb::where(['uuid'=> $uuid])->first();
        return view('initial-data.bpbs.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'year' => 'required',
            'last_bpb_coal' => 'required',
            'last_bpb_solar' => 'required',
            'last_bpb_residu' => 'required',
        ], [
            'year.required' => 'Pemasok wajib diisi.',
            'last_bpb_coal.required' => 'BPB terakhir batubara wajib diisi.',
            'last_bpb_solar.required' => 'BPB terakhir solar wajib diisi.',
            'last_bpb_residu.required' => 'BPB terakhir residu wajib diisi.',
        ]);

        SettingBpb::where([
            'uuid' => $uuid,
        ])->update([
            'year' => $request->year,
            'last_bpb_coal' => $request->last_bpb_coal,
            'last_bpb_solar' => $request->last_bpb_solar,
            'last_bpb_residu' => $request->last_bpb_residu,
        ]);

        return redirect(route('initial-data.settings-bpb.index'))->with('success', 'Data berhasil diupdate.');
    }
}
