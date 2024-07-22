<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'nombres' => $this->faker->firstName,
            'apepat' => $this->faker->lastName,
            'apemat' => $this->faker->lastName,
            'fechanac' => $this->faker->date,
            'telefono' => $this->faker->phoneNumber,
            'rol' => 'medico',
            'sexo' => $this->faker->randomElement(['masculino', 'femenino']), // Nuevo campo
            'activo' => 'si',
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];
    }
}
