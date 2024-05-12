<?php

namespace App\Http\Controllers\MasterData\HeavyEquipment;

use App\HeavyEquipment;
use App\HeavyEquipmentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeavyEquipmentController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['heavy_equipment_type_uuid'] = $request->input('heavy_equipment_type');
        $data['heavy_equipment_types'] = HeavyEquipmentType::get();
        $query = HeavyEquipment::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        if ($data['heavy_equipment_type_uuid']) {
            $query->where('heavy_equipment_type_uuid', '=', $data['heavy_equipment_type_uuid']);
        }

        $data['heavy_equipments'] = $query->paginate(10);
        $data['heavy_equipments']->appends(request()->query());
        return view('master-data.heavy-equipments.index', $data);
    }

    public function edit($uuid){
        $data['heavy_equipment'] = HeavyEquipment::where(['uuid'=> $uuid])->first();
        $data['heavy_equipment_types'] = HeavyEquipmentType::get();
        return view('master-data.heavy-equipments.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'heavy_equipment_type_uuid' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'heavy_equipment_type_uuid.required' => 'Type alat berat wajib diisi.',
        ]);

        HeavyEquipment::where(['uuid' => $uuid])->update([
            'name' => $request->name,
            'heavy_equipment_type_uuid' => $request->heavy_equipment_type_uuid,
        ]);

        return redirect(route('master-data.heavy-equipments.index'))->with('success', 'Alat berat berhasil diupdate.');
    }

    public function create(){
        $data['heavy_equipment_types'] = HeavyEquipmentType::get();

        return view('master-data.heavy-equipments.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'heavy_equipment_type_uuid' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'heavy_equipment_type_uuid.required' => 'Type Alat Berat wajib diisi.',
        ]);

        $type_ship = HeavyEquipment::create([
            'name' => $request->name,
            'heavy_equipment_type_uuid' => $request->heavy_equipment_type_uuid,
        ]);

        return redirect(route('master-data.heavy-equipments.index'))->with('success', 'Alat berat baru berhasil dibuat.');
    }

    public function destroy($uuid){
        HeavyEquipment::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.heavy-equipments.index'))->with('success', 'Berhasil menghapus data.');
    }
}
