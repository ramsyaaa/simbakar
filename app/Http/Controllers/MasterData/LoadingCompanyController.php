<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\LoadingCompany;
use Illuminate\Http\Request;

class LoadingCompanyController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = LoadingCompany::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }

        $data['loading_companies'] = $query->paginate(10);
        $data['loading_companies']->appends(request()->query());
        return view('master-data.loading-companies.index', $data);
    }

    public function create(){
        return view('master-data.loading-companies.create');
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

        LoadingCompany::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.load-companies.index'))->with('success', 'Perusahaan bongkar muat baru berhasil dibuat.');
    }

    public function destroy($uuid){
        LoadingCompany::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.load-companies.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function edit($uuid){
        $data['load_company'] = LoadingCompany::where(['uuid'=> $uuid])->first();
        return view('master-data.loading-companies.edit', $data);
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

        LoadingCompany::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'fax' => $request->fax,
        ]);

        return redirect(route('master-data.load-companies.index'))->with('success', 'Perusahaan bongkar muat berhasil diupdate.');
    }
}
