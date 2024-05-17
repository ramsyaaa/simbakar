<?php

namespace App\Http\Controllers\MasterData\Dock;

use App\DockEquipment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = DockEquipment::query();
        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['equipments'] = $query->paginate(10);
        $data['equipments']->appends(request()->query());
        return view('master-data.docks.equipments.index', $data);
    }

    public function edit($uuid){
        $data['equipment'] = DockEquipment::where(['uuid'=> $uuid])->first();
        return view('master-data.docks.equipments.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        DockEquipment::where(['uuid' => $uuid])->update([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.docks.equipments.index'))->with('success', 'Peralatan berhasil diupdate.');
    }

    public function create(){
        return view('master-data.docks.equipments.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        DockEquipment::create([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.docks.equipments.index'))->with('success', 'Peralatan baru berhasil dibuat.');
    }

    public function destroy($uuid){
        DockEquipment::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.docks.equipments.index'))->with('success', 'Berhasil menghapus data.');
    }
}
