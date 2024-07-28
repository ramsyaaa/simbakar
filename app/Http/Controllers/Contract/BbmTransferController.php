<?php

namespace App\Http\Controllers\Contract;

use App\Bunkers;
use App\Supplier;
use App\Models\BbmTransfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BbmTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bbms = BbmTransfer::query();

        $date = explode('-',$request->date);
        $bbms->when($request->date, function ($query) use ($date) {
            $query->whereMonth('created_at', $date[1]);
            $query->whereYear('created_at', $date[0]);
        });
        $data['bbms'] = $bbms->paginate(10)->appends(request()->query());

        return view('contracts.bbm-transfers.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['bunkers'] = Bunkers::all();
        return view('contracts.bbm-transfers.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           
            BbmTransfer::create($request->all());
    
            return redirect(route('contracts.bbm-transfers.index'))->with('success', 'Transfer Bbm berhasil dibuat.');
            
        } catch (\ValidationException $th) {
            throw $th;
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['bbm'] = BbmTransfer::where('id', $id)->first();
        $data['bunkers'] = Bunkers::all();
        return view('contracts.bbm-transfers.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        BbmTransfer::where('id', $id)->update($request->except(['_token','_method']));
        return redirect(route('contracts.bbm-transfers.index'))->with('success', 'Transfer Bbm berhasil di ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BbmTransfer::where('id', $id)->delete();
        return redirect(route('contracts.bbm-transfers.index'))->with('success', 'Transfer Bbm berhasil di hapus.');
    }
}
