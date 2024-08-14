<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            ModelHasRolesTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
        ]);
    }
}

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'nombres' => 'Daniel',
                'apepat' => 'Ledezma',
                'apemat' => 'Donjuan',
                'fechanac' => '2003-07-01',
                'telefono' => '8341550734',
                'sexo' => 'masculino',
                'activo' => 'si',
                'email' => '2130147@upv.edu.mx',
                'password' => Hash::make('D4n13l2003'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Administrador', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Medico', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Enfermera', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Secretaria', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'Agregar Pacientes', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Editar Paciente', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Eliminar Paciente', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Agregar Citas', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Editar Citas', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Consultar', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Editar Consultas', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Vista Pacientes', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Vista Medicos', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Vista Enfermeras', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Vista Secretarias', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Vista Citas', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Vista Consultas', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Vista Roles', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Vista Permisos', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Vista Usuarios', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}


class ModelHasRolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('model_has_roles')->insert([
            ['role_id' => 1, 'model_type' => 'App\Models\User', 'model_id' => 1],
        ]);
    }
}

class RoleHasPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('role_has_permissions')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
            ['permission_id' => 6, 'role_id' => 1],
            ['permission_id' => 7, 'role_id' => 1],
            ['permission_id' => 14, 'role_id' => 1],
            ['permission_id' => 15, 'role_id' => 1],
            ['permission_id' => 16, 'role_id' => 1],
            ['permission_id' => 17, 'role_id' => 1],
            ['permission_id' => 18, 'role_id' => 1],
            ['permission_id' => 19, 'role_id' => 1],
            ['permission_id' => 22, 'role_id' => 1],
            ['permission_id' => 23, 'role_id' => 1],
            ['permission_id' => 24, 'role_id' => 1],

            ['permission_id' => 14, 'role_id' => 2],
            ['permission_id' => 16, 'role_id' => 2],
            ['permission_id' => 17, 'role_id' => 2],
            ['permission_id' => 18, 'role_id' => 2],
            ['permission_id' => 19, 'role_id' => 2],
            ['permission_id' => 24, 'role_id' => 2],

            ['permission_id' => 14, 'role_id' => 3],
            ['permission_id' => 17, 'role_id' => 3],
            ['permission_id' => 18, 'role_id' => 3],

            ['permission_id' => 14, 'role_id' => 4],
            ['permission_id' => 16, 'role_id' => 4],
            ['permission_id' => 18, 'role_id' => 4],
        ]);
    }
}


