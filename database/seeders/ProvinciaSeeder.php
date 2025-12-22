<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provincias = [

            // 1 Amazonas
            ['region_id' => 1, 'nombre' => 'Chachapoyas'],
            ['region_id' => 1, 'nombre' => 'Bagua'],
            ['region_id' => 1, 'nombre' => 'Bongará'],
            ['region_id' => 1, 'nombre' => 'Condorcanqui'],
            ['region_id' => 1, 'nombre' => 'Luya'],
            ['region_id' => 1, 'nombre' => 'Rodríguez de Mendoza'],
            ['region_id' => 1, 'nombre' => 'Utcubamba'],

            // 2 Áncash
            ['region_id' => 2, 'nombre' => 'Huaraz'],
            ['region_id' => 2, 'nombre' => 'Aija'],
            ['region_id' => 2, 'nombre' => 'Antonio Raymondi'],
            ['region_id' => 2, 'nombre' => 'Asunción'],
            ['region_id' => 2, 'nombre' => 'Bolognesi'],
            ['region_id' => 2, 'nombre' => 'Carhuaz'],
            ['region_id' => 2, 'nombre' => 'Casma'],
            ['region_id' => 2, 'nombre' => 'Corongo'],
            ['region_id' => 2, 'nombre' => 'Huari'],
            ['region_id' => 2, 'nombre' => 'Huarmey'],
            ['region_id' => 2, 'nombre' => 'Huaylas'],
            ['region_id' => 2, 'nombre' => 'Mariscal Luzuriaga'],
            ['region_id' => 2, 'nombre' => 'Ocros'],
            ['region_id' => 2, 'nombre' => 'Pallasca'],
            ['region_id' => 2, 'nombre' => 'Pomabamba'],
            ['region_id' => 2, 'nombre' => 'Recuay'],
            ['region_id' => 2, 'nombre' => 'Santa'],
            ['region_id' => 2, 'nombre' => 'Sihuas'],
            ['region_id' => 2, 'nombre' => 'Yungay'],

            // 3 Apurímac
            ['region_id' => 3, 'nombre' => 'Abancay'],
            ['region_id' => 3, 'nombre' => 'Andahuaylas'],
            ['region_id' => 3, 'nombre' => 'Antabamba'],
            ['region_id' => 3, 'nombre' => 'Aymaraes'],
            ['region_id' => 3, 'nombre' => 'Cotabambas'],
            ['region_id' => 3, 'nombre' => 'Chincheros'],
            ['region_id' => 3, 'nombre' => 'Grau'],

            // 4 Arequipa
            ['region_id' => 4, 'nombre' => 'Arequipa'],
            ['region_id' => 4, 'nombre' => 'Camaná'],
            ['region_id' => 4, 'nombre' => 'Caravelí'],
            ['region_id' => 4, 'nombre' => 'Castilla'],
            ['region_id' => 4, 'nombre' => 'Caylloma'],
            ['region_id' => 4, 'nombre' => 'Condesuyos'],
            ['region_id' => 4, 'nombre' => 'Islay'],
            ['region_id' => 4, 'nombre' => 'La Unión'],

            // 5 Ayacucho
            ['region_id' => 5, 'nombre' => 'Huamanga'],
            ['region_id' => 5, 'nombre' => 'Cangallo'],
            ['region_id' => 5, 'nombre' => 'Huanca Sancos'],
            ['region_id' => 5, 'nombre' => 'Huanta'],
            ['region_id' => 5, 'nombre' => 'La Mar'],
            ['region_id' => 5, 'nombre' => 'Lucanas'],
            ['region_id' => 5, 'nombre' => 'Parinacochas'],
            ['region_id' => 5, 'nombre' => 'Páucar del Sara Sara'],
            ['region_id' => 5, 'nombre' => 'Sucre'],
            ['region_id' => 5, 'nombre' => 'Víctor Fajardo'],
            ['region_id' => 5, 'nombre' => 'Vilcas Huamán'],

            // 6 Cajamarca
            ['region_id' => 6, 'nombre' => 'Cajamarca'],
            ['region_id' => 6, 'nombre' => 'Cajabamba'],
            ['region_id' => 6, 'nombre' => 'Celendín'],
            ['region_id' => 6, 'nombre' => 'Chota'],
            ['region_id' => 6, 'nombre' => 'Contumazá'],
            ['region_id' => 6, 'nombre' => 'Cutervo'],
            ['region_id' => 6, 'nombre' => 'Hualgayoc'],
            ['region_id' => 6, 'nombre' => 'Jaén'],
            ['region_id' => 6, 'nombre' => 'San Ignacio'],
            ['region_id' => 6, 'nombre' => 'San Marcos'],
            ['region_id' => 6, 'nombre' => 'San Miguel'],
            ['region_id' => 6, 'nombre' => 'San Pablo'],
            ['region_id' => 6, 'nombre' => 'Santa Cruz'],

            // 7 Callao
            ['region_id' => 7, 'nombre' => 'Callao'],

            // 8 Cusco
            ['region_id' => 8, 'nombre' => 'Cusco'],
            ['region_id' => 8, 'nombre' => 'Acomayo'],
            ['region_id' => 8, 'nombre' => 'Anta'],
            ['region_id' => 8, 'nombre' => 'Calca'],
            ['region_id' => 8, 'nombre' => 'Canas'],
            ['region_id' => 8, 'nombre' => 'Canchis'],
            ['region_id' => 8, 'nombre' => 'Chumbivilcas'],
            ['region_id' => 8, 'nombre' => 'Espinar'],
            ['region_id' => 8, 'nombre' => 'La Convención'],
            ['region_id' => 8, 'nombre' => 'Paruro'],
            ['region_id' => 8, 'nombre' => 'Paucartambo'],
            ['region_id' => 8, 'nombre' => 'Quispicanchi'],
            ['region_id' => 8, 'nombre' => 'Urubamba'],

            // 15 Lima
            ['region_id' => 15, 'nombre' => 'Lima'],
            ['region_id' => 15, 'nombre' => 'Barranca'],
            ['region_id' => 15, 'nombre' => 'Cajatambo'],
            ['region_id' => 15, 'nombre' => 'Cañete'],
            ['region_id' => 15, 'nombre' => 'Huaral'],
            ['region_id' => 15, 'nombre' => 'Huarochirí'],
            ['region_id' => 15, 'nombre' => 'Huaura'],
            ['region_id' => 15, 'nombre' => 'Oyón'],
            ['region_id' => 15, 'nombre' => 'Yauyos'],

            // 16 Loreto
            ['region_id' => 16, 'nombre' => 'Maynas'],
            ['region_id' => 16, 'nombre' => 'Alto Amazonas'],
            ['region_id' => 16, 'nombre' => 'Loreto'],
            ['region_id' => 16, 'nombre' => 'Mariscal Ramón Castilla'],
            ['region_id' => 16, 'nombre' => 'Requena'],
            ['region_id' => 16, 'nombre' => 'Ucayali'],
            ['region_id' => 16, 'nombre' => 'Datem del Marañón'],
            ['region_id' => 16, 'nombre' => 'Putumayo'],

            // 17 Madre de Dios
            ['region_id' => 17, 'nombre' => 'Tambopata'],
            ['region_id' => 17, 'nombre' => 'Manu'],
            ['region_id' => 17, 'nombre' => 'Tahuamanu'],

            // 18 Moquegua
            ['region_id' => 18, 'nombre' => 'Mariscal Nieto'],
            ['region_id' => 18, 'nombre' => 'General Sánchez Cerro'],
            ['region_id' => 18, 'nombre' => 'Ilo'],

            // 19 Pasco
            ['region_id' => 19, 'nombre' => 'Pasco'],
            ['region_id' => 19, 'nombre' => 'Daniel Alcides Carrión'],
            ['region_id' => 19, 'nombre' => 'Oxapampa'],

            // 20 Piura
            ['region_id' => 20, 'nombre' => 'Piura'],
            ['region_id' => 20, 'nombre' => 'Ayabaca'],
            ['region_id' => 20, 'nombre' => 'Huancabamba'],
            ['region_id' => 20, 'nombre' => 'Morropón'],
            ['region_id' => 20, 'nombre' => 'Paita'],
            ['region_id' => 20, 'nombre' => 'Sechura'],
            ['region_id' => 20, 'nombre' => 'Sullana'],
            ['region_id' => 20, 'nombre' => 'Talara'],

            // 21 Puno
            ['region_id' => 21, 'nombre' => 'Puno'],
            ['region_id' => 21, 'nombre' => 'Azángaro'],
            ['region_id' => 21, 'nombre' => 'Carabaya'],
            ['region_id' => 21, 'nombre' => 'Chucuito'],
            ['region_id' => 21, 'nombre' => 'El Collao'],
            ['region_id' => 21, 'nombre' => 'Huancané'],
            ['region_id' => 21, 'nombre' => 'Lampa'],
            ['region_id' => 21, 'nombre' => 'Melgar'],
            ['region_id' => 21, 'nombre' => 'Moho'],
            ['region_id' => 21, 'nombre' => 'San Antonio de Putina'],
            ['region_id' => 21, 'nombre' => 'San Román'],
            ['region_id' => 21, 'nombre' => 'Sandia'],
            ['region_id' => 21, 'nombre' => 'Yunguyo'],

            // 22 San Martín
            ['region_id' => 22, 'nombre' => 'Moyobamba'],
            ['region_id' => 22, 'nombre' => 'Bellavista'],
            ['region_id' => 22, 'nombre' => 'El Dorado'],
            ['region_id' => 22, 'nombre' => 'Huallaga'],
            ['region_id' => 22, 'nombre' => 'Lamas'],
            ['region_id' => 22, 'nombre' => 'Mariscal Cáceres'],
            ['region_id' => 22, 'nombre' => 'Picota'],
            ['region_id' => 22, 'nombre' => 'Rioja'],
            ['region_id' => 22, 'nombre' => 'San Martín'],
            ['region_id' => 22, 'nombre' => 'Tocache'],

            // 23 Tacna
            ['region_id' => 23, 'nombre' => 'Tacna'],
            ['region_id' => 23, 'nombre' => 'Candarave'],
            ['region_id' => 23, 'nombre' => 'Jorge Basadre'],
            ['region_id' => 23, 'nombre' => 'Tarata'],

            // 24 Tumbes
            ['region_id' => 24, 'nombre' => 'Tumbes'],
            ['region_id' => 24, 'nombre' => 'Contralmirante Villar'],
            ['region_id' => 24, 'nombre' => 'Zarumilla'],

            // 25 Ucayali
            ['region_id' => 25, 'nombre' => 'Coronel Portillo'],
            ['region_id' => 25, 'nombre' => 'Atalaya'],
            ['region_id' => 25, 'nombre' => 'Padre Abad'],
            ['region_id' => 25, 'nombre' => 'Purús']
        ];

        foreach ($provincias as $provincia) {
            DB::table('provincias')->insert([
                'departamento_id' => $provincia['region_id'],
                'nombre' => $provincia['nombre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
