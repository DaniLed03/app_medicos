<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'nombres' => 'Daniel',
            'apepat' => 'Ledezma',
            'apemat' => 'Donjuan',
            'fechanac' => '2003-07-01',
            'telefono' => '8341550734',
            'rol' => 'medico',
            'sexo' => 'masculino', 
            'activo' => 'si',
            'email' => '2130147@upv.edu.mx',
            'password' => bcrypt('D4n13l2003'),
        ]);
    }
}
