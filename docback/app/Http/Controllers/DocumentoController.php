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

    public function concategoria(){
        return DB::SELECT('SELECT c.nombre,count(*) as cantidad from documentos d inner join categorias c on d.categoria_id=c.id  group by c.nombre');
    }

    public function consubcategoria(){
        return DB::SELECT('SELECT c.nombre,count(*) as cantidad from documentos d inner join subcategorias c on d.subcategoria_id=c.id  group by c.nombre');
    }

    public function totales(){
        return DB::SELECT('SELECT(SELECT count(*)FROM documentos)as docs ,
        (SELECT count(*) FROM prestamos)as nprestamo,
        (SELECT count(*) FROM prestamos where fechadevolucion is not null)as ndevol');
    }

    public function reporte(Request $request){
        $i=0;
        $doc= Documento::with('categoria')->with('subcategoria')->get();
        $total=sizeof($doc);
        $cadena="<html>
        <style>
        table, th, td {
            border: 1px solid black;
          }
          table{width:100%;
            border-collapse: collapse;}
            .titulo{
                text-align:center;
                font-weight: bold;
            }
            .subt{
                font-weight: bold;
            }
            .imagen{width:100px;
                height:100px;}
                *{
                    padding: 0px;
                    margin: 0px;
                    border: 0px;}
        </style>

        <body>
        <table>
        <tr><td><img class='imagen' src='img/estado.png'></td><td class='titulo'>AUTORIDAD PLURINACIONAL DE LA  MADRE TIERRA <br> INVENTARIO DE ARCHIVO DE GESTION</td><td ><img class='imagen' src='img/fondo.jpg'></td></tr>
        </table>
        <table>
        <tr><td colspan=3>1. AREA DE DATOS GENERALES</td></tr>
        <tr><td><b>UNIDAD/DIRECCION</b> </td><td>FECHA DE REPORTE</td><td>".date('Y-m-d')."</td></tr>
        <tr><td><b>RESPONSABLE DE UNIDAD/DIRECCION</b>". $request->user()->name."</td><td>TOTAL REPORTES</td><td>".$total."</td></tr>
        <tr></tr>
        <tr><td colspan=3>2. AREA DE DESCRIPCION DE ARCHIVOS</td></tr>

        </table>
        <table>
        <thead><tr><th>Nº</th><th>TITULO EXPEDIENTE</th><th>CATEGORIA</th><th>SUBCATEGORIA</th><th>FECHA DE CREACION</th></tr></thead>
        <tbody>";
        foreach ($doc as $row) {
            $i++;
            $cadena.="<tr><td>$i</td><td>$row->detalles</td><td>".$row->categoria['nombre']."</td><td>".$row->subcategoria['nombre']."</td>
            <td>$row->fecha</td></tr>";
        }
        $cadena.="</tbody></table>";
        return $cadena;
    }
}
