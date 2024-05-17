<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Transporter;
use Illuminate\Http\Request;

class TransporterController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = Transporter::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['transporters'] = $query->paginate(10);
        $data['transporters']->appends(request()->query());
        return view('master-data.transporters.index', $data);
    }

    public function create(){
        return view('master-data.transporters.create');
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

        Transporter::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.transporters.index'))->with('success', 'Transportir baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Transporter::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.transporters.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['transporter'] = Transporter::where(['uuid'=> $uuid])->first();
        return view('master-data.transporters.edit', $data);
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

        Transporter::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.transporters.index'))->with('success', 'Transportir berhasil diupdate.');
    }
}
