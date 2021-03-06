<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
//            UnitSeeder::class,
            UserSeeder::class,
            PermisoSeeder::class,
            PermisoUserSeeder::class,
            CategoriaSeeder::class,
            SubcategoriaSeeder::class,
            DocumentoSeeder::class,
            PrestamoSeeder::class
//            MailSeeder::class,
//            LogSeeder::class,
        ]);
    }
}
