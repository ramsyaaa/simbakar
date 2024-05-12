<?php

namespace App\Http\Controllers\MasterData\Dock;

use App\Dock;
use App\DockEquipment;
use App\DockEquipmentList;
use App\DockInspectionParameter;
use App\DockInspectionParameterList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

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
        $data['dock_equipment_lists'] = DockEquipment::get();
        $data['dock_inspection_lists'] = DockInspectionParameter::get();
        return view('master-data.docks.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'length' => 'required',
            'width' => 'required',
            'draft' => 'required',
            'dock_equipment_lists' => 'required|array',
            'dock_inspection_lists' => 'required|array'
        ], [
            'name.required' => 'Dermaga wajib diisi.',
            'length.required' => 'Length wajib diisi.',
            'width.required' => 'Width wajib diisi.',
            'draft.required' => 'Draft wajib diisi.',
            'dock_equipment_lists.required' => 'List peralatan wajib diisi.',
            'dock_inspection_lists.required' => 'List pengecekan wajib diisi.',
        ]);

        $dock = Dock::create([
            'name' => $request->name,
            'length' => $request->length,
            'width' => $request->width,
            'draft' => $request->draft,
        ]);

        $dock_equipment_lists = [];
        foreach ($request->dock_equipment_lists as $key => $list) {
            $dock_equipment_lists[] = [
                'dock_uuid' => $dock->uuid,
                'dock_equipment_uuid' => $list,
            ];
        }
        $dock_inspection_lists = [];
        foreach ($request->dock_inspection_lists as $key => $list) {
            $dock_inspection_lists[] = [
                'dock_uuid' => $dock->uuid,
                'dock_inspection_parameter_uuid' => $list,
            ];
        }
        DockInspectionParameterList::insert($dock_inspection_lists);
        DockEquipmentList::insert($dock_equipment_lists);

        return redirect(route('master-data.docks.index'))->with('success', 'Dermaga baru berhasil dibuat.');
    }

    public function edit($uuid){
        $data['dock'] = Dock::where(['uuid'=> $uuid])->first();
        $data['dock_equipment_lists'] = DockEquipment::get();
        $data['dock_inspection_lists'] = DockInspectionParameter::get();
        $data['inspection_selected'] = DockEquipmentList::pluck('dock_equipment_uuid');
        $data['equipment_selected'] = DockInspectionParameterList::pluck('dock_inspection_parameter_uuid');
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
            'dock_equipment_lists' => 'required|array',
            'dock_inspection_lists' => 'required|array'
        ], [
            'name.required' => 'Dermaga wajib diisi.',
            'length.required' => 'Length wajib diisi.',
            'width.required' => 'Width wajib diisi.',
            'draft.required' => 'Draft wajib diisi.',
            'dock_equipment_lists.required' => 'List peralatan wajib diisi.',
            'dock_inspection_lists.required' => 'List pengecekan wajib diisi.',
        ]);

        Dock::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
            'length' => $request->length,
            'width' => $request->width,
            'draft' => $request->draft,
        ]);

        DockInspectionParameterList::where([
            'dock_uuid' => $uuid,
        ])->delete();
        DockEquipmentList::where([
            'dock_uuid' => $uuid,
        ])->delete();

        $dock_equipment_lists = [];
        foreach ($request->dock_equipment_lists as $key => $list) {
            $dock_equipment_lists[] = [
                'dock_uuid' => $uuid,
                'dock_equipment_uuid' => $list,
            ];
        }
        $dock_inspection_lists = [];
        foreach ($request->dock_inspection_lists as $key => $list) {
            $dock_inspection_lists[] = [
                'dock_uuid' => $uuid,
                'dock_inspection_parameter_uuid' => $list,
            ];
        }
        DockInspectionParameterList::insert($dock_inspection_lists);
        DockEquipmentList::insert($dock_equipment_lists);

        return redirect(route('master-data.docks.index'))->with('success', 'Update dermaga berhasil dilakukan.');
    }

    public function destroy($uuid){
        Dock::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.docks.index'))->with('success', 'Berhasil menghapus data.');
    }
}
