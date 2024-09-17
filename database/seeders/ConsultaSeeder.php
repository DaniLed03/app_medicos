<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ConsultaSeeder extends Seeder
{
    public function run()
    {
        DB::table('conceptos')->insert([
            'id_concepto' => 1,
            'concepto' => 'Consulta',
            'precio_unitario' => 100,
            'impuesto' => 0,
            'unidad_medida' => 'UNO',
            'tipo_concepto' => 'Servicio',
            'medico_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
