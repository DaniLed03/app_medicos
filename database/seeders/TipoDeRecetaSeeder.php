<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDeRecetaSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipo_de_receta')->insert([
            ['id' => 1, 'nombre' => 'Medicamentos', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Estudios de Gabinete', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Estudios de Laboratorio', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nombre' => 'Recomendaciones', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nombre' => 'Rayos X', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
