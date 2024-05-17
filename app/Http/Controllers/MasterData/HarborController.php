<?php

namespace App\Http\Controllers\MasterData;

use App\Harbor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HarborController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = Harbor::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['harbors'] = $query->paginate(10);
        $data['harbors']->appends(request()->query());
        return view('master-data.harbors.index', $data);
    }

    public function create(){
        return view('master-data.harbors.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        Harbor::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect(route('master-data.harbors.index'))->with('success', 'Pelabuhan baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Harbor::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.harbors.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['harbor'] = Harbor::where(['uuid'=> $uuid])->first();
        return view('master-data.harbors.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        Harbor::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect(route('master-data.harbors.index'))->with('success', 'Pelabuhan berhasil diupdate.');
    }
}
