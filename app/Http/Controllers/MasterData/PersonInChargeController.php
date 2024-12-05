<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\PersonInCharge;
use Illuminate\Http\Request;

class PersonInChargeController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = PersonInCharge::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['person_in_charges'] = $query->paginate(10);
        $data['person_in_charges']->appends(request()->query());
        return view('master-data.person-in-charges.index', $data);
    }

    public function create(){
        return view('master-data.person-in-charges.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'structural_position' => 'required',
            'functional_role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'structural_position.required' => 'Jabatan struktural wajib diisi.',
            'name_position.required' => 'Nama Jabatan wajib diisi.',
            'functional_role.required' => 'Jabatan fungsioinal wajib diisi.',
        ]);

        PersonInCharge::create([
            'name' => $request->name,
            'structural_position' => $request->structural_position,
            'name_position' => $request->name_position,
            'functional_role' => $request->functional_role,
            'status' => 1
        ]);

        return redirect(route('master-data.person-in-charges.index'))->with('success', 'Penanggung jawab baru berhasil dibuat.');
    }

    public function destroy($uuid){
        PersonInCharge::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.person-in-charges.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['person_in_charge'] = PersonInCharge::where(['uuid'=> $uuid])->first();
        return view('master-data.person-in-charges.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'structural_position' => 'required',
            'functional_role' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'structural_position.required' => 'Jabatan struktural wajib diisi.',
            'functional_role.required' => 'Jabatan fungsioinal wajib diisi.',
        ]);

        PersonInCharge::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'name_position' => $request->name_position,
            'structural_position' => $request->structural_position,
            'functional_role' => $request->functional_role,
            'status' => $request->status
        ]);

        return redirect(route('master-data.person-in-charges.index'))->with('success', 'Penanggung jawab berhasil diupdate.');
    }
}
