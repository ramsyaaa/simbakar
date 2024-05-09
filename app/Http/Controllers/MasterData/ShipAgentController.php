<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\LoadType;
use App\ShipAgent;
use Illuminate\Http\Request;

class ShipAgentController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['load_type_uuid'] = $request->input('load_type');
        $data['load_types'] = LoadType::get();
        $query = ShipAgent::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        if ($data['load_type_uuid']) {
            $query->where('load_type_uuid', '=', $data['load_type_uuid']);
        }

        $data['ship_agents'] = $query->paginate(10);
        $data['ship_agents']->appends(request()->query());
        return view('master-data.ship-agents.index', $data);
    }

    public function create(){
        $data['load_types'] = LoadType::get();
        return view('master-data.ship-agents.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'load_type_uuid' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
        ]);

        ShipAgent::create([
            'name' => $request->name,
            'load_type_uuid' => $request->load_type_uuid,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.ship-agents.index'))->with('success', 'Agen kapal baru berhasil dibuat.');
    }

    public function destroy($uuid){
        ShipAgent::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.ship-agents.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['ship_agent'] = ShipAgent::where(['uuid'=> $uuid])->first();
        $data['load_types'] = LoadType::get();
        return view('master-data.ship-agents.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'load_type_uuid' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
        ]);

        ShipAgent::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'load_type_uuid' => $request->load_type_uuid,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.ship-agents.index'))->with('success', 'Agen kapal berhasil diupdate.');
    }
}
