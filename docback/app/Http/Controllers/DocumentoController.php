<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Documento::with('categoria')->with('subcategoria')->get();
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
        //


        $nombreArchivo='';
        if ($request->hasFile('imagen')) {
//            return "si";
            $file=$request->file('imagen');
            $nombreArchivo = $request->archivo.".".$file->getClientOriginalExtension();
//        return $nombreArchivo;
            $file->move(\public_path('imagenes'), $nombreArchivo);
//            return $nombreArchivo;
//            $request->imagen=$nombreArchivo;
        }
        $doc=new Documento;
        $doc->fondo=$request->fondo;
        $doc->archivo=$nombreArchivo;
        $doc->gestion=$request->gestion;
        $doc->tomo=$request->tomo;
        $doc->numtotal=$request->numtotal;
        $doc->detalle=$request->detalle;
        $doc->fecha=date('Y-m-d');
        $doc->categoria_id=$request->categoria_id;
        $doc->subcategoria_id=$request->subcategoria_id;
        $doc->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */

     public function uparchivo(Request $request){
        $nombreArchivo='';
        if ($request->hasFile('imagen')) {
//            return "si";
            $file=$request->file('imagen');
            $nombreArchivo = $request->archivo.".".$file->getClientOriginalExtension();
//        return $nombreArchivo;
            $file->move(\public_path('imagenes'), $nombreArchivo);
//            return $nombreArchivo;
//            $request->imagen=$nombreArchivo;
        }
        $doc=Documento::find($request->id);
        $doc->archivo=$nombreArchivo;
        $doc->save();
     }
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        
        $doc=Documento::find($request->id);
        $doc->fondo=$request->fondo;
        $doc->gestion=$request->gestion;
        $doc->tomo=$request->tomo;
        $doc->numtotal=$request->numtotal;
        $doc->detalle=$request->detalle;
        $doc->categoria_id=$request->categoria_id;
        $doc->subcategoria_id=$request->subcategoria_id;
        $doc->save();
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $doc=Documento::find($id);
        $doc->delete();

    }

    public function consulta(Request $request){
        return DB::SELECT('SELECT fecha,count(*) as cantidad from documentos where fecha>= "'.$request->fecha1.'" and fecha<="'.$request->fecha2.'" group by fecha');
    }
}
