<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("prestamos")->insert([
            "fechaprestamo"=>"2021-11-27",
//            "fechadevolucion"=>null,
            "observacion"=>"",
            "estado"=>"PEDIDO",
            'user_id'=>"1",
            'documento_id'=>"1",
        ]);
    }
}
