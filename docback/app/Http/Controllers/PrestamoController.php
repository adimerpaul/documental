<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $request->user();
        return Prestamo::
                with('user')
            ->with('documento')
            ->where('user_id',$request->user()->id)
            ->where('estado','ACEPTADO')
            ->orWhere('estado','SOLICITADO')
            ->get();
    }

    public function misprestamo(Request $request){
        return Prestamo::
        with('user')
    ->with('documento')
    ->where('user_id',$request->user()->id)
    ->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        $validar=Prestamo::where('user_id',$request->user()->id)->where('estado',"SOLICITADO")->where('documento_id',$request->documento_id)->get();
        if(sizeof($validar)==0){
        $prestamo=new Prestamo();
        $prestamo->fechaprestamo=now();
        $prestamo->fechadevolucion=null;
        $prestamo->observacion='';
        $prestamo->estado="SOLICITADO";
        $prestamo->user_id=$request->user()->id;
        $prestamo->documento_id=$request->documento_id;
        $prestamo->save();}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return $id;
        return Prestamo::with('user')->with('documento')->where('estado','SOLICITADO')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestamo $prestamo)
    {
//        return $request;
        $prestamo->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
    }

    public function conprestamo(Request $request){
        return DB::SELECT('SELECT fechaprestamo,count(*) as cantidad from prestamos where fechaprestamo>= "'.$request->fecha1.'" and fechaprestamo<="'.$request->fecha2.'" group by fechaprestamo');
    }
}
