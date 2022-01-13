<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("documentos")->insert([
            "cod"=>"1",
            "fondo"=>"APMT",
            "archivo"=>"1.pdf",
            "gestion"=>"2021",
            "tomo"=>"1",
            "fecha"=>now(),
            "numtotal"=>"10",
            "detalle"=>"CONVENIOS",
            'categoria_id'=>"1",
            'subcategoria_id'=>"1",
        ]);
    }
}
