<?php

namespace App\Http\Controllers\Tug;

use App\BbmUsage;
use App\Models\Tug;
use App\Models\CoalUsage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TugTwelveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        if($request->has('date')){
           $coal = CoalUsage::select('tug_9_number')->where('usage_date', $request->date)->get();
           $bbm = BbmUsage::select('tug9_number AS tug_9_number')->where('use_date', $request->date)->get();
           $merged = $coal->concat($bbm);
           $data['tugs'] = $merged->chunk(6)->map(function ($item){
                return $item->pad(6,null);
            });
        }
        return view('inputs.tug-12.index',$data);

    }
    public function detail($id){

        $data['tug'] = Tug::where('id',$id)->first();
        return view('inputs.tug-12.index',$data);
    }
    public function destroy($id)
    {
        Tug::where('id', $id)->delete();
        return redirect(route('inputs.tug-12.index'))->with('success', 'Pembongkaran Batu Bara berhasil di hapus.');
    }
}
