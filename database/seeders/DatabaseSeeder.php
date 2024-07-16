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
            'activo' => 'si',
            'email' => '2130147@upv.edu.mx',
            'password' => bcrypt('D4n13l2003'), // Asegúrate de usar bcrypt para encriptar la contraseña
        ]);

        User::factory()->create([
            'nombres' => 'Daniel',
            'apepat' => 'Ledezma',
            'apemat' => 'Ledezma',
            'fechanac' => '2024-07-03',
            'telefono' => '8341550734',
            'rol' => 'secretaria',
            'activo' => 'si',
            'email' => '2130148@upv.edu.mx',
            'password' => bcrypt('D4n13l2003'),
        ]);

        User::factory()->create([
            'nombres' => 'Santa Lorena',
            'apepat' => 'Hernandez',
            'apemat' => 'Turrubiates',
            'fechanac' => '2003-04-25',
            'telefono' => '8341550735',
            'rol' => 'enfermera',
            'activo' => 'si',
            'email' => 'santa@gmail.com',
            'password' => bcrypt('D4n13l2003'),
        ]);
    }
}
