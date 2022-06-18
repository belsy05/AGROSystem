<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Cargo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriaSeeder::class);
        $this->call(PresentacionSeeder::class);
        $this->call(ProductoSeeder::class);

        $this->call(ClienteTableSeeder::class);
        $this->call(ProveedorTableSeeder::class);
        $this->call(CargoTableSeeder::class);
        $this->call(PersonalTableSeeder::class);
        $this->call(RangoTableSeeder::class);
    }
}
