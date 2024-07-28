<?php

namespace App\Http\Controllers\Tug;

use App\Models\Tug;
use Illuminate\Http\Request;
use App\Models\HeadWarehouse;
use App\Http\Controllers\Controller;

class TugElevenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['heads'] = HeadWarehouse::all();
        return view('inputs.tug-11.index',$data);

    }
    public function detail($id){

        $data['tug'] = Tug::where('id',$id)->first();
        return view('inputs.tug-11.index',$data);
    }
    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-11.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
