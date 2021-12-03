<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos')->insert([
            ["nombre"=>'Control de usuarios'],
            ["nombre"=>'Registro de categoria'],
            ["nombre"=>'Registro de documento'],
            ["nombre"=>'Aceptar solicitudes'],
            ["nombre"=>'Solicitar prestamos'],
            ["nombre"=>'Mis solicitudes'],
        ]);
    }
}
