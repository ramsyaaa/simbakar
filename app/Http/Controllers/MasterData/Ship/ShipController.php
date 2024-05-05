<?php

namespace App\Http\Controllers\MasterData\Ship;

use App\Http\Controllers\Controller;
use App\LoadType;
use App\Models\TypeShip;
use App\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['load_type_uuid'] = $request->input('load_type');
        $data['type_ship_uuid'] = $request->input('type_ship');
        $data['type_ships'] = TypeShip::get();
        $data['load_types'] = LoadType::get();
        $query = Ship::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        if ($data['load_type_uuid']) {
            $query->where('load_type_uuid', '=', $data['load_type_uuid']);
        }
        if ($data['type_ship_uuid']) {
            $query->where('type_ship_uuid', '=', $data['type_ship_uuid']);
        }

        $data['ships'] = $query->paginate(10);
        $data['ships']->appends(request()->query());
        return view('master-data.ships.index', $data);
    }

    public function edit($uuid){
        $data['ship'] = Ship::where(['uuid'=> $uuid])->first();
        $data['load_types'] = LoadType::get();
        $data['type_ships'] = TypeShip::get();
        return view('master-data.ships.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'type_ship_uuid' => 'required',
            'flag' => 'required',
            'load_type_uuid' => 'required',
            'year_created' => 'required',
            'grt' => 'required',
            'dwt' => 'required',
            'loa' => 'required'
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'type_ship_uuid.required' => 'Type kapal wajib diisi.',
            'flag.required' => 'Bendera wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'year_created.required' => 'Tahun pembuatan wajib diisi.',
            'grt.required' => 'GRT wajib diisi.',
            'dwt.required' => 'DWT wajib diisi.',
            'loa.required' => 'LOA wajib diisi.',
        ]);

        $type_ship = Ship::where(['uuid' => $uuid])->update([
            'name' => $request->name,
            'type_ship_uuid' => $request->type_ship_uuid,
            'flag' => $request->flag,
            'load_type_uuid' => $request->load_type_uuid,
            'year_created' => $request->year_created,
            'grt' => $request->grt,
            'dwt' => $request->dwt,
            'loa' => $request->loa,
            'status' => 1,
        ]);

        return redirect(route('master-data.ships.index'))->with('success', 'Kapal berhasil diupdate.');
    }

    public function create(){
        $data['load_types'] = LoadType::get();
        $data['type_ships'] = TypeShip::get();

        return view('master-data.ships.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'type_ship_uuid' => 'required',
            'flag' => 'required',
            'load_type_uuid' => 'required',
            'year_created' => 'required',
            'grt' => 'required',
            'dwt' => 'required',
            'loa' => 'required'
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'type_ship_uuid.required' => 'Type kapal wajib diisi.',
            'flag.required' => 'Bendera wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'year_created.required' => 'Tahun pembuatan wajib diisi.',
            'grt.required' => 'GRT wajib diisi.',
            'dwt.required' => 'DWT wajib diisi.',
            'loa.required' => 'LOA wajib diisi.',
        ]);

        $type_ship = Ship::create([
            'name' => $request->name,
            'type_ship_uuid' => $request->type_ship_uuid,
            'flag' => $request->flag,
            'load_type_uuid' => $request->load_type_uuid,
            'year_created' => $request->year_created,
            'grt' => $request->grt,
            'dwt' => $request->dwt,
            'loa' => $request->loa,
            'status' => 1,
        ]);

        return redirect(route('master-data.ships.index'))->with('success', 'Kapal baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Ship::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.ships.index'))->with('success', 'Berhasil menghapus data.');
    }
}
