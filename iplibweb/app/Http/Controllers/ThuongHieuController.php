<?php

namespace App\Http\Controllers;

use App\ThuongHieu;
use Illuminate\Http\Request;

class ThuongHieuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($so_hieu)
    {
        return view( 'thuong_hieu', array( 'thuong_hieu' => ThuongHieu::where('so_hieu', $so_hieu)->first() ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function search(Request $request)
    {
        $data = ThuongHieu::search($request->all());
        return view('search',array('thuong_hieus' => $data['rows'], 'total_page' => $data['total_page']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function show(ThuongHieu $thuongHieu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function edit(ThuongHieu $thuongHieu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThuongHieu $thuongHieu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ThuongHieu  $thuongHieu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThuongHieu $thuongHieu)
    {
        //
    }
}
