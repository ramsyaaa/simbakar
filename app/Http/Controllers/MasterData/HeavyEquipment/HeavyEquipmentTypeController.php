<?php

namespace App\Http\Controllers\MasterData\HeavyEquipment;

use App\HeavyEquipmentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeavyEquipmentTypeController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = HeavyEquipmentType::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['heavy_equipment_types'] = $query->paginate(10);
        $data['heavy_equipment_types']->appends(request()->query());
        return view('master-data.heavy-equipments.heavy-equipment-types.index', $data);
    }

    public function create(){
        return view('master-data.heavy-equipments.heavy-equipment-types.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
        ]);

        HeavyEquipmentType::create([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.heavy-equipments.type.index'))->with('success', 'Jenis alat berat baru berhasil dibuat.');
    }

    public function edit($uuid){
        $data['heavy_equipment_type'] = HeavyEquipmentType::where(['uuid'=> $uuid])->first();
        return view('master-data.heavy-equipments.heavy-equipment-types.edit', $data);
    }

    public function destroy($uuid){
        HeavyEquipmentType::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.heavy-equipments.type.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
        ]);

        HeavyEquipmentType::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.heavy-equipments.type.index'))->with('success', 'Update jenis alat berat berhasil dilakukan.');
    }
}
