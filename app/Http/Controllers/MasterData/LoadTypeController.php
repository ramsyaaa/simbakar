<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\LoadType;
use Illuminate\Http\Request;

class LoadTypeController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = LoadType::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['load_types'] = $query->paginate(10);
        $data['load_types']->appends(request()->query());
        return view('master-data.load-type.index', $data);
    }

    public function create(){
        return view('master-data.load-type.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:load_types',
        ], [
            'name.required' => 'Jenis muatan wajib diisi.',
            'name.unique' => 'Jenis muatan sudah ada.',
        ]);

        LoadType::create([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.load-type.index'))->with('success', 'Jenis muatan baru berhasil dibuat.');
    }

    public function edit($uuid){
        $data['load_type'] = LoadType::where(['uuid'=> $uuid])->first();
        return view('master-data.load-type.edit', $data);
    }

    public function update(Request $request, $uuid){
        $user = LoadType::where([
            'uuid' => $uuid,
        ])->first();

        $validate_name = 'required|unique:load_types';
        if($user->name == $request->name){
            $validate_name = 'required';
        }

        $request->validate([
            'name' => $validate_name,
        ], [
            'name.required' => 'Jenis muatan wajib diisi.',
            'name.unique' => 'Jenis muatan sudah ada.',
        ]);

        LoadType::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.load-type.index'))->with('success', 'Update jenis muatan berhasil dilakukan.');
    }

    public function destroy($uuid){
        LoadType::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.load-type.index'))->with('success', 'Berhasil menghapus data.');
    }
}
