<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paises')->insert([
            [
                'nombre' => 'Perú',
                'codigo' => 'PER',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
