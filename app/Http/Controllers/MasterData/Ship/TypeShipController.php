<?php

namespace App\Http\Controllers\MasterData\Ship;

use App\Dock;
use App\Http\Controllers\Controller;
use App\Models\TypeShip;
use App\TypeShipDockAvailability;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TypeShipController extends Controller
{
    public function index(Request $request){
        $data['find'] = $request->input('find');
        $query = TypeShip::query();

        if ($data['find']) {
            $query->where('name', 'like', '%' . $data['find'] . '%');
        }
        $data['type_ships'] = $query->paginate(10);
        $data['type_ships']->appends(request()->query());
        return view('master-data.ships.type-ship.index', $data);
    }

    public function create(){
        $data['docks'] = Dock::get();
        return view('master-data.ships.type-ship.create', $data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|unique:type_ships',
            'docks' => 'required|array'
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'name.unique' => 'Jenis kapal sudah ada.',
            'docks.required' => 'Dermaga wajib diisi.',
        ]);

        $type_ship = TypeShip::create([
            'name' => $request->name,
        ]);

        $docks = [];
        foreach ($request->docks as $key => $dock) {
            $docks[] = [
                'uuid' => Uuid::uuid4()->toString(),
                'type_ship_uuid' => $type_ship->uuid,
                'dock_uuid' => $dock,
            ];
        }
        TypeShipDockAvailability::insert($docks);

        return redirect(route('master-data.ships.type-ship.index'))->with('success', 'Jenis kapal baru berhasil dibuat.');
    }

    public function edit($uuid){
        $data['type_ship'] = TypeShip::where(['uuid'=> $uuid])->first();
        $data['docks'] = Dock::get();
        $data['dock_selected'] = TypeShipDockAvailability::pluck('dock_uuid');
        return view('master-data.ships.type-ship.edit', $data);
    }

    public function destroy($uuid){
        TypeShip::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.ships.type-ship.index'))->with('success', 'Berhasil menghapus data.');
    }

    public function update(Request $request, $uuid){
        $type_ship = TypeShip::where([
            'uuid' => $uuid,
        ])->first();

        $validate_name = 'required|unique:type_ships';
        if($type_ship->name == $request->name){
            $validate_name = 'required';
        }

        $request->validate([
            'name' => $validate_name,
            'docks' => 'required|array'
        ], [
            'name.required' => 'Jenis kapal wajib diisi.',
            'name.unique' => 'Jenis kapal sudah ada.',
            'docks.required' => 'Dermaga wajib diisi.',
        ]);

        TypeShip::where([
            'uuid' => $uuid,
        ])->update([
            'name' => $request->name,
        ]);

        TypeShipDockAvailability::where([
            'type_ship_uuid' => $type_ship->uuid,
        ])->delete();

        $docks = [];
        foreach ($request->docks as $key => $dock) {
            $docks[] = [
                'uuid' => Uuid::uuid4()->toString(),
                'type_ship_uuid' => $type_ship->uuid,
                'dock_uuid' => $dock,
            ];
        }
        TypeShipDockAvailability::insert($docks);

        return redirect(route('master-data.ships.type-ship.index'))->with('success', 'Update jenis kapal berhasil dilakukan.');
    }
}
