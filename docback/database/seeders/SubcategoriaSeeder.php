<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("subcategorias")->insert([
            ["codigo"=>"1.1","nombre"=>"CORRESPONDENCIA CORRIENTE","sigla"=>"","fecha"=>"2021-11-27","categoria_id"=>1],
            ["codigo"=>"1.1.1","nombre"=>"CORRESPONDENCIA INTERNA","sigla"=>"CI","fecha"=>"2021-11-27","categoria_id"=>1],
        ]);
    }
}
