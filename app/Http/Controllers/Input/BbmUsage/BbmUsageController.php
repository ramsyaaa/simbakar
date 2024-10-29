<?php

namespace App\Http\Controllers\Input\BbmUsage;

use App\BbmUsage;
use App\Bunkers;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use App\Models\Tug;
use App\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BbmUsageController extends Controller
{
    public function index(Request $request, $bbm_use_for)
    {
        $data['bbm_use_for'] = $bbm_use_for;

        if (!in_array($data['bbm_use_for'], ['unit', 'heavy_equipment', 'other'])) {
            $data['bbm_use_for'] = "unit";
        }

        $date = $request->date ?? Carbon::now()->format('Y-m-d');
        $data['date'] = $date;

        $bbm_usages = BbmUsage::query();

        $bbm_usages->where(['bbm_use_for' => $bbm_use_for, 'use_date' => $date]);

        if($data['bbm_use_for'] == "unit"){
            $data['units'] = Unit::get();

            if(isset($request->unit_uuid)){
                $bbm_usages->where(['unit_uuid' => $request->unit_uuid]);
                $data['unit_uuid'] = $request->unit_uuid;
            }

            $data['bbm_usages'] = $bbm_usages->join('units', 'bbm_usages.unit_uuid', '=', 'units.uuid')
                    ->select('bbm_usages.id', 'bbm_usages.*', 'units.name') // Hanya ambil ID dari `bbm_usages`
                    ->orderBy('units.name', 'asc')
                    ->paginate(10)
                    ->appends(request()->query());
        }else{
            $data['bbm_usages'] = $bbm_usages
                                ->select('bbm_usages.id', 'bbm_usages.*')
                                ->paginate(10)
                                ->appends(request()->query());
        }

        return view('inputs.bbm_usage.bbm_usage.index', ['bbm_use_for' => $bbm_use_for],$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($bbm_use_for)
    {
        $data['bbm_use_for'] = $bbm_use_for;

        if($data['bbm_use_for'] != "unit" && $data['bbm_use_for'] != 'heavy_equipment' && $data['bbm_use_for'] != 'other'){
            $data['bbm_use_for'] = "unit";
        }

        $data['units'] = Unit::get();
        $data['heavy_equipments'] = HeavyEquipment::get();
        $data['bunkers'] = Bunkers::get();
        return view('inputs.bbm_usage.bbm_usage.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $bbm_use_for)
    {
        $request->validate([
            'unit_uuid' => $bbm_use_for == 'unit' ? 'required' : '',
            'heavy_equipment_uuid' => $bbm_use_for == 'heavy_equipment' ? 'required' : '',
            'bunker_uuid' => 'required',
            'bbm_type' => 'required',
            'tug9_number' => ['required', 'unique:tugs,tug_number'],
            'use_date' => 'required',
            'amount' => 'required',
            'description' => $bbm_use_for == 'other' ? 'required' : '',
        ], [
            'bbm_use_for.required' => 'Peruntukkan BBM wajib diisi',
            'unit_uuid.required' => 'Unit wajib diisi jika peruntukkan BBM adalah unit',
            'heavy_equipment_uuid.required' => 'Albes diisi jika peruntukkan BBM adalah albes',
            'description.required' => 'Keterangan wajib diisi jika peruntukkan BBM adalah lainnya',
            'bunker_uuid.required' => 'Bunker wajib diisi',
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'tug9_number.required' => 'No TUG9 wajib diisi',
            'tug9_number.unique' => 'No TUG9 sudah digunakan',
            'use_date.required' => 'Tanggal pakai wajib diisi',
            'amount.required' => 'Jumlah pakai wajib diisi',
        ]);

        $bbm = BbmUsage::create([
            'bbm_use_for' => $bbm_use_for,
            'unit_uuid' => $request->unit_uuid,
            'heavy_equipment_uuid' => $request->heavy_equipment_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'bbm_type' => $request->bbm_type,
            'tug9_number' => $request->tug9_number,
            'use_date' => $request->use_date,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        Tug::create([
                'tug' => 9,
                'tug_number' => $request->tug9_number,
                'type_tug' => 'bbm-usage',
                'usage_amount' => $request->amount,
                'unit' => 'L',
                'type_fuel' => $request->bbm_type,
                'bbm_usage_id' => $bbm->id,
            ]);

        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for, 'date' => $request->use_date]))->with('success', 'Pemakaian BBM baru baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bbm_use_for, $id)
    {
        $data['bbm_use_for'] = $bbm_use_for;

        if($data['bbm_use_for'] != "unit" && $data['bbm_use_for'] != 'heavy_equipment' && $data['bbm_use_for'] != 'other'){
            $data['bbm_use_for'] = "unit";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bbm_use_for, $id)
    {
        $data['bbm_use_for'] = $bbm_use_for;

        if($data['bbm_use_for'] != "unit" && $data['bbm_use_for'] != 'heavy_equipment' && $data['bbm_use_for'] != 'other'){
            $data['bbm_use_for'] = "unit";
        }

        $data['bbm'] = BbmUsage::where('id', $id)->first();
        $data['units'] = Unit::get();
        $data['heavy_equipments'] = HeavyEquipment::get();
        $data['bunkers'] = Bunkers::get();
        return view('inputs.bbm_usage.bbm_usage.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bbm_use_for, $id)
    {
        $get_bbm_usage = BbmUsage::where([
            'id' => $id,
        ])->first();

        if($get_bbm_usage == null){
            return;
        }

        $request->validate([
            'unit_uuid' => $bbm_use_for == 'unit' ? 'required' : '',
            'heavy_equipment_uuid' => $bbm_use_for == 'heavy_equipment' ? 'required' : '',
            'bunker_uuid' => 'required',
            'bbm_type' => 'required',
            'tug9_number' => ['required', $get_bbm_usage->tug9_number != $request->tug9_number ? 'unique:tugs,tug_number' : ''],
            'use_date' => 'required',
            'amount' => 'required',
            'description' => $bbm_use_for == 'other' ? 'required' : '',
        ], [
            'bbm_use_for.required' => 'Peruntukkan BBM wajib diisi',
            'unit_uuid.required' => 'Unit wajib diisi jika peruntukkan BBM adalah unit',
            'heavy_equipment_uuid.required' => 'Albes diisi jika peruntukkan BBM adalah albes',
            'description.required' => 'Keterangan wajib diisi jika peruntukkan BBM adalah lainnya',
            'bunker_uuid.required' => 'Bunker wajib diisi',
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'tug9_number.required' => 'No TUG9 wajib diisi',
            'tug9_number.unique' => 'No TUG9 sudah digunakan',
            'use_date.required' => 'Tanggal pakai wajib diisi',
            'amount.required' => 'Jumlah pakai wajib diisi',
        ]);

        BbmUsage::where('id',$id)->update([
            'bbm_use_for' => $bbm_use_for,
            'unit_uuid' => $request->unit_uuid,
            'heavy_equipment_uuid' => $request->heavy_equipment_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'bbm_type' => $request->bbm_type,
            'tug9_number' => $request->tug9_number,
            'use_date' => $request->use_date,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        Tug::where([
            'bbm_usage_id' => $id,
            ])->update([
                'tug' => 9,
                'tug_number' => $request->tug9_number,
                'type_tug' => 'bbm-usage',
                'usage_amount' => $request->amount,
                'unit' => 'L',
                'type_fuel' => $request->bbm_type,
            ]);

        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for, 'date' => $request->use_date]))->with('success', 'Pemakaian BBM berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bbm_use_for, $id)
    {
        $bbmUsage = BbmUsage::where('id',$id)->first();
        BbmUsage::where('id',$id)->first()->delete();
        
        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for, 'date' => $bbmUsage->use_date]))->with('success', 'Pemakaian BBM berhasil dihapus.');
    }
}
