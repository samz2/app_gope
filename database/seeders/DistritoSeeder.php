<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distritos = [

            // 144 Coronel Portillo
            ['provincia_id' => 144, 'nombre' => 'Callería'],
            ['provincia_id' => 144, 'nombre' => 'Campoverde'],
            ['provincia_id' => 144, 'nombre' => 'Iparía'],
            ['provincia_id' => 144, 'nombre' => 'Masisea'],
            ['provincia_id' => 144, 'nombre' => 'Yarinacocha'],
            ['provincia_id' => 144, 'nombre' => 'Nueva Requena'],
            ['provincia_id' => 144, 'nombre' => 'Manantay'],

            // 145 Atalaya
            ['provincia_id' => 145, 'nombre' => 'Atalaya'],
            ['provincia_id' => 145, 'nombre' => 'Raymondi'],
            ['provincia_id' => 145, 'nombre' => 'Sepahua'],
            ['provincia_id' => 145, 'nombre' => 'Tahuanía'],
            ['provincia_id' => 145, 'nombre' => 'Yurúa'],

            // 146 Padre Abad
            ['provincia_id' => 146, 'nombre' => 'Padre Abad'],
            ['provincia_id' => 146, 'nombre' => 'Irazola'],
            ['provincia_id' => 146, 'nombre' => 'Curimaná'],
            ['provincia_id' => 146, 'nombre' => 'Neshuya'],
            ['provincia_id' => 146, 'nombre' => 'Alexander von Humboldt'],

            // 147 Purús
            ['provincia_id' => 147, 'nombre' => 'Purús'],
        ];

        foreach ($distritos as $distrito) {
            DB::table('distritos')->insert([
                'provincia_id' => $distrito['provincia_id'],
                'nombre' => $distrito['nombre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
