<?php

namespace App\Http\Controllers\MasterData;
use App\Http\Controllers\Controller;
use App\LoadType;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $data['load_type_uuid'] = $request->input('load_type');
        $data['load_types'] = LoadType::get();
        $query = Supplier::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        if ($data['load_type_uuid']) {
            $query->where('load_type_uuid', '=', $data['load_type_uuid']);
        }

        $data['suppliers'] = $query->paginate(10);
        $data['suppliers']->appends(request()->query());
        return view('master-data.suppliers.index', $data);
    }

    public function create(){
        $data['load_types'] = LoadType::get();
        return view('master-data.suppliers.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'load_type_uuid' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'bg_color' => 'nullable',
            'mining_authorization' => 'required',
            'mine_name' => 'required',
            'mine_location' => 'required',
            'producer' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
            'mining_authorization.required' => 'Kuasa pertambangan wajib diisi.',
            'mine_name.required' => 'Nama tambang wajib diisi.',
            'mine_location.required' => 'Lokasi tambang wajib diisi.',
            'producer.required' => 'Producer wajib diisi.',
        ]);

        Supplier::create([
            'name' => $request->name,
            'load_type_uuid' => $request->load_type_uuid,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'bg_color' => $request->bg_color,
            'mining_authorization' => $request->mining_authorization,
            'mine_name' => $request->mine_name,
            'mine_location' => $request->mine_location,
            'producer' => $request->producer,
        ]);

        return redirect(route('master-data.suppliers.index'))->with('success', 'Pemasok baru berhasil dibuat.');
    }

    public function destroy($uuid){
        Supplier::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.suppliers.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['supplier'] = Supplier::where(['uuid'=> $uuid])->first();
        $data['load_types'] = LoadType::get();
        return view('master-data.suppliers.edit', $data);
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'name' => 'required',
            'load_type_uuid' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'fax' => 'required',
            'bg_color' => 'nullable',
            'mining_authorization' => 'required',
            'mine_name' => 'required',
            'mine_location' => 'required',
            'producer' => 'required',
        ], [
            'name.required' => 'Pemasok wajib diisi.',
            'load_type_uuid.required' => 'Type muatan wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'phone.required' => 'Telp wajib diisi.',
            'fax.required' => 'Fax wajib diisi.',
            'mining_authorization.required' => 'Kuasa pertambangan wajib diisi.',
            'mine_name.required' => 'Nama tambang wajib diisi.',
            'mine_location.required' => 'Lokasi tambang wajib diisi.',
            'producer.required' => 'Producer wajib diisi.',
        ]);

        Supplier::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'load_type_uuid' => $request->load_type_uuid,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
            'bg_color' => $request->bg_color,
            'mining_authorization' => $request->mining_authorization,
            'mine_name' => $request->mine_name,
            'mine_location' => $request->mine_location,
            'producer' => $request->producer,
        ]);

        return redirect(route('master-data.suppliers.index'))->with('success', 'Pemasok berhasil diupdate.');
    }
}
