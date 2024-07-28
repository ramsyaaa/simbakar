<?php

namespace App\Http\Controllers\Input\BbmUsage;

use App\BbmUsage;
use App\Bunkers;
use App\HeavyEquipment;
use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;

class BbmUsageController extends Controller
{
    public function index(Request $request, $bbm_use_for)
    {
        $data['bbm_use_for'] = $bbm_use_for;

        if($data['bbm_use_for'] != "unit" && $data['bbm_use_for'] != 'heavy_equipment' && $data['bbm_use_for'] != 'other'){
            $data['bbm_use_for'] = "unit";
        }

        $bbm_usages = BbmUsage::query();

        $bbm_usages->where(['bbm_use_for' => $bbm_use_for])->when($request->year, function ($query) use ($request) {
            $query->whereYear('created_at', $request->year);
        });

        $data['bbm_usages'] = $bbm_usages->paginate(10)->appends(request()->query());
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
            'tug9_number' => 'required',
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
            'use_date.required' => 'Tanggal pakai wajib diisi',
            'amount.required' => 'Jumlah pakai wajib diisi',
        ]);

        BbmUsage::create([
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

        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for]))->with('success', 'Pemakaian BBM baru baru berhasil dibuat.');
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
        $request->validate([
            'unit_uuid' => $bbm_use_for == 'unit' ? 'required' : '',
            'heavy_equipment_uuid' => $bbm_use_for == 'heavy_equipment' ? 'required' : '',
            'bunker_uuid' => 'required',
            'bbm_type' => 'required',
            'tug9_number' => 'required',
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

        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for]))->with('success', 'Pemakaian BBM berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bbm_use_for, $id)
    {
        BbmUsage::where('id',$id)->first()->delete();

        return redirect(route('inputs.bbm_usage.index', ['bbm_use_for' => $bbm_use_for]))->with('success', 'Pemakaian BBM berhasil dihapus.');
    }
}
