<?php

namespace App\Http\Controllers\MasterData\Dock;

use App\DockInspectionParameter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DockInspectionController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = DockInspectionParameter::query();
        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['inspections'] = $query->paginate(10);
        $data['inspections']->appends(request()->query());
        return view('master-data.docks.inspections.index', $data);
    }

    public function edit($uuid){
        $data['inspection'] = DockInspectionParameter::where(['uuid'=> $uuid])->first();
        return view('master-data.docks.inspections.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        DockInspectionParameter::where(['uuid' => $uuid])->update([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.docks.inspections.index'))->with('success', 'Parameter inspeksi berhasil diupdate.');
    }

    public function create(){
        return view('master-data.docks.inspections.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
        ]);

        DockInspectionParameter::create([
            'name' => $request->name,
        ]);

        return redirect(route('master-data.docks.inspections.index'))->with('success', 'Parameter inspeksi baru berhasil dibuat.');
    }

    public function destroy($uuid){
        DockInspectionParameter::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.docks.inspections.index'))->with('success', 'Berhasil menghapus data.');
    }
}
