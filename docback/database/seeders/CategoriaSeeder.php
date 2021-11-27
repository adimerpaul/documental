<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("categorias")->insert([
            ["codigo"=>"1","nombre"=>"DIRECCION EJECUTIVA","sigla"=>"DE","fecha"=>"2021-11-27"],
            ["codigo"=>"2","nombre"=>"UNIDAD DE PLANIFICACION Y DESARROLLO ORGANIZACIONAL","sigla"=>"UPDO","fecha"=>"2021-11-27"],
        ]);
    }
}
