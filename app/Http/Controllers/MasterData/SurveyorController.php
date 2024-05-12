<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Surveyor;
use Illuminate\Http\Request;

class SurveyorController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = Surveyor::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['surveyors'] = $query->paginate(10);
        $data['surveyors']->appends(request()->query());
        return view('master-data.surveyors.index', $data);
    }

    public function create(){
        return view('master-data.surveyors.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
        ]);

        Surveyor::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.surveyors.index'))->with('success', 'Surveyor baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Surveyor::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.surveyors.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['surveyor'] = Surveyor::where(['uuid'=> $uuid])->first();
        return view('master-data.surveyors.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
        ]);

        Surveyor::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.surveyors.index'))->with('success', 'Surveyor berhasil diupdate.');
    }
}
