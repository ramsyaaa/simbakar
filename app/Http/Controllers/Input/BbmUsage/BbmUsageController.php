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
    public function index(Request $request)
    {
        $bbm_usages = BbmUsage::query();

        $bbm_usages->when($request->year, function ($query) use ($request) {
            $query->whereYear('created_at', $request->year);
        });

        $data['bbm_usages'] = $bbm_usages->paginate(10)->appends(request()->query());
        return view('inputs.bbm_usage.bbm_usage.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
    public function store(Request $request)
    {
        $request->validate([
            'bbm_use_for' => 'required',
            'unit_uuid' => 'required_if:bbm_use_for,unit',
            'heavy_equipment_uuid' => 'required_if:bbm_use_for,heavy_equipment',
            'bunker_uuid' => 'required',
            'bbm_type' => 'required',
            'tug9_number' => 'required',
            'use_date' => 'required',
            'amount' => 'required',
            'description' => 'required_if:bbm_use_for,other',
        ], [
            'bbm_use_for.required' => 'Peruntukkan BBM wajib diisi',
            'unit_uuid.required_if' => 'Unit wajib diisi jika peruntukkan BBM adalah unit',
            'heavy_equipment_uuid.required_if' => 'Albes diisi jika peruntukkan BBM adalah albes',
            'description.required_if' => 'Keterangan wajib diisi jika peruntukkan BBM adalah lainnya',
            'bunker_uuid.required' => 'Bunker wajib diisi',
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'tug9_number.required' => 'No TUG9 wajib diisi',
            'use_date.required' => 'Tanggal pakai wajib diisi',
            'amount.required' => 'Jumlah pakai wajib diisi',
        ]);

        BbmUsage::create([
            'bbm_use_for' => $request->bbm_use_for,
            'unit_uuid' => $request->unit_uuid,
            'heavy_equipment_uuid' => $request->heavy_equipment_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'bbm_type' => $request->bbm_type,
            'tug9_number' => $request->tug9_number,
            'use_date' => $request->use_date,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect(route('inputs.bbm_usage.index'))->with('success', 'Pemakaian BBM baru baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'bbm_use_for' => 'required',
            'unit_uuid' => 'required_if:bbm_use_for,unit',
            'heavy_equipment_uuid' => 'required_if:bbm_use_for,heavy_equipment',
            'bunker_uuid' => 'required',
            'bbm_type' => 'required',
            'tug9_number' => 'required',
            'use_date' => 'required',
            'amount' => 'required',
            'description' => 'required_if:bbm_use_for,other',
        ], [
            'bbm_use_for.required' => 'Peruntukkan BBM wajib diisi',
            'unit_uuid.required_if' => 'Unit wajib diisi jika peruntukkan BBM adalah unit',
            'heavy_equipment_uuid.required_if' => 'Albes diisi jika peruntukkan BBM adalah albes',
            'description.required_if' => 'Keterangan wajib diisi jika peruntukkan BBM adalah lainnya',
            'bunker_uuid.required' => 'Bunker wajib diisi',
            'bbm_type.required' => 'Jenis BBM wajib diisi',
            'tug9_number.required' => 'No TUG9 wajib diisi',
            'use_date.required' => 'Tanggal pakai wajib diisi',
            'amount.required' => 'Jumlah pakai wajib diisi',
        ]);

        BbmUsage::where('id',$id)->update([
            'bbm_use_for' => $request->bbm_use_for,
            'unit_uuid' => $request->unit_uuid,
            'heavy_equipment_uuid' => $request->heavy_equipment_uuid,
            'bunker_uuid' => $request->bunker_uuid,
            'bbm_type' => $request->bbm_type,
            'tug9_number' => $request->tug9_number,
            'use_date' => $request->use_date,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect(route('inputs.bbm_usage.index'))->with('success', 'Pemakaian BBM berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BbmUsage::where('id',$id)->first()->delete();

        return redirect(route('inputs.bbm_usage.index'))->with('success', 'Pemakaian BBM berhasil dihapus.');
    }
}
