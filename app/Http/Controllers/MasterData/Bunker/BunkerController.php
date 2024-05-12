<?php

namespace App\Http\Controllers\MasterData\Bunker;

use App\Bunkers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BunkerController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['bunker_type'] = $request->input('bunker_type');
        $query = Bunkers::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        if ($data['bunker_type']) {
            $query->where('bunker_type', '=', $data['bunker_type']);
        }

        $data['bunkers'] = $query->paginate(10);
        $data['bunkers']->appends(request()->query());
        return view('master-data.bunkers.index', $data);
    }

    public function edit($uuid){
        $data['bunker'] = Bunkers::where(['uuid'=> $uuid])->first();
        return view('master-data.bunkers.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'bunker_type' => 'required',
            'capacity' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'bunker_type.required' => 'Type bunker wajib diisi.',
            'capacity.required' => 'Kapasitas wajib diisi.',
        ]);

        Bunkers::where(['uuid' => $uuid])->update([
            'name' => $request->name,
            'bunker_type' => $request->bunker_type,
            'capacity' => $request->capacity,
        ]);

        return redirect(route('master-data.bunkers.index'))->with('success', 'Bunker berhasil diupdate.');
    }

    public function create(){
        return view('master-data.bunkers.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'bunker_type' => 'required',
            'capacity' => 'required',
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'bunker_type.required' => 'Type bunker wajib diisi.',
            'capacity.required' => 'Kapasitas wajib diisi.',
        ]);

        Bunkers::create([
            'name' => $request->name,
            'bunker_type' => $request->bunker_type,
            'capacity' => $request->capacity,
        ]);

        return redirect(route('master-data.bunkers.index'))->with('success', 'Bunker baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Bunkers::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.bunkers.index'))->with('success', 'Berhasil menghapus data.');
    }
}
