<?php

namespace App\Http\Controllers\MasterData\Bunker;

use App\Bunkers;
use App\BunkerSounding;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SoundingController extends Controller
{
    public function index(Request $request, $bunker_uuid){
        $bunker = Bunkers::where('uuid', $bunker_uuid)->first();
        if($bunker == null){
            return redirect(route('master-data.bunkers.index'))->with('error', 'Bunker not found.');
        }
        $data['bunker_uuid'] =$bunker_uuid;
        $data['bunker_name'] = $bunker->name;
        $query = BunkerSounding::query();
        $data['soundings'] = $query->paginate(10);
        $data['soundings']->appends(request()->query());
        return view('master-data.bunkers.soundings.index', $data);
    }

    public function edit($bunker_uuid, $uuid){
        $bunker = Bunkers::where('uuid', $bunker_uuid)->first();
        if($bunker == null){
            return redirect(route('master-data.bunkers.index'))->with('error', 'Bunker not found.');
        }
        $data['bunker_uuid'] =$bunker_uuid;
        $data['bunker_name'] = $bunker->name;
        $data['sounding'] = BunkerSounding::where(['uuid'=> $uuid])->first();
        return view('master-data.bunkers.soundings.edit', $data);
    }

    public function update(Request $request, $bunker_uuid, $uuid){
        $request->validate([
            'meter' => '',
            'centimeter' => '',
            'milimeter' => '',
            'volume' => '',
        ], [
            'meter.required' => 'Meter wajib diisi.',
            'centimeter.required' => 'Centimeter wajib diisi.',
            'milimeter.required' => 'Milimeter wajib diisi.',
            'volume.required' => 'Volume wajib diisi.',
        ]);

        BunkerSounding::where(['uuid' => $uuid])->update([
            'meter' => $request->meter,
            'centimeter' => $request->centimeter,
            'milimeter' => $request->milimeter,
            'volume' => $request->volume,
        ]);

        return redirect(route('master-data.bunkers.soundings.index', ['bunker_uuid' => $bunker_uuid]))->with('success', 'Sounding berhasil diupdate.');
    }

    public function create($bunker_uuid){
        $bunker = Bunkers::where('uuid', $bunker_uuid)->first();
        if($bunker == null){
            return redirect(route('master-data.bunkers.index'))->with('error', 'Bunker not found.');
        }
        $data['bunker_uuid'] =$bunker_uuid;
        $data['bunker_name'] = $bunker->name;
        return view('master-data.bunkers.soundings.create', $data);
    }

    public function store(Request $request, $bunker_uuid){
        $request->validate([
            'meter' => '',
            'centimeter' => '',
            'milimeter' => '',
            'volume' => '',
        ], [
            'meter.required' => 'Meter wajib diisi.',
            'centimeter.required' => 'Centimeter wajib diisi.',
            'milimeter.required' => 'Milimeter wajib diisi.',
            'volume.required' => 'Volume wajib diisi.',
        ]);

        BunkerSounding::create([
            'bunker_uuid' => $bunker_uuid,
            'meter' => $request->meter,
            'centimeter' => $request->centimeter,
            'milimeter' => $request->milimeter,
            'volume' => $request->volume,
        ]);

        return redirect(route('master-data.bunkers.soundings.index', ['bunker_uuid' => $bunker_uuid]))->with('success', 'Sounding berhasil dibuat.');
    }

    public function destroy($bunker_uuid, $uuid){
        BunkerSounding::where([
            'uuid' => $uuid,
        ])->delete();

        return redirect(route('master-data.bunkers.soundings.index', ['bunker_uuid', $bunker_uuid]))->with('success', 'Berhasil menghapus data.');
    }
}
