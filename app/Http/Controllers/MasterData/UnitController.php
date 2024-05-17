<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = Unit::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['units'] = $query->paginate(10);
        $data['units']->appends(request()->query());
        return view('master-data.units.index', $data);
    }

    public function create(){
        return view('master-data.units.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
        ]);

        Unit::create([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.units.index'))->with('success', 'Unit baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Unit::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.units.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['unit'] = Unit::where(['uuid'=> $uuid])->first();
        return view('master-data.units.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
        ]);

        Unit::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.units.index'))->with('success', 'Unit berhasil diupdate.');
    }
}
