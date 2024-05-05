<?php

namespace App\Http\Controllers\MasterData;

use App\Dock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DockController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = Dock::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['docks'] = $query->paginate(10);
        $data['docks']->appends(request()->query());
        return view('master-data.docks.index', $data);
    }

    public function create(){
        return view('master-data.docks.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'length' => 'required',
            'width' => 'required',
            'draft' => 'required',
        ], [
            'name.required' => 'Dermaga wajib diisi.',
            'length.required' => 'Length wajib diisi.',
            'width.required' => 'Width wajib diisi.',
            'draft.required' => 'Draft wajib diisi.',
        ]);

        Dock::create([
            'name' => $request->name,
            'length' => $request->length,
            'width' => $request->width,
            'draft' => $request->draft,
        ]);

        return redirect(route('master-data.docks.index'))->with('success', 'Dermaga baru berhasil dibuat.');
    }

    public function edit($uuid){
        $data['dock'] = Dock::where(['uuid'=> $uuid])->first();
        return view('master-data.docks.edit', $data);
    }

    public function update(Request $request, $uuid){
        $user = Dock::where([
            'uuid' => $uuid,
        ])->first();

        $request->validate([
            'name' => 'required',
            'length' => 'required',
            'width' => 'required',
            'draft' => 'required',
        ], [
            'name.required' => 'Dermaga wajib diisi.',
            'length.required' => 'Length wajib diisi.',
            'width.required' => 'Width wajib diisi.',
            'draft.required' => 'Draft wajib diisi.',
        ]);

        Dock::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'length' => $request->length,
            'width' => $request->width,
            'draft' => $request->draft,
        ]);

        return redirect(route('master-data.docks.index'))->with('success', 'Update dermaga berhasil dilakukan.');
    }

    public function destroy($uuid){
        Dock::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.docks.index'))->with('success', 'Berhasil menghapus data.');
    }
}
