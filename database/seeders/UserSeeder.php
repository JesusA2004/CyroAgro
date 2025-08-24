<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario administrador por defecto
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@cyragro.com',
            'password' => 'Admin1234', // se hashea automáticamente por el cast/mutator
            'role' => 'administrador',
        ]);

        // Usuario empleado
        User::create([
            'name' => 'Empleado Demo',
            'email' => 'empleado@cyragro.com',
            'password' => 'Empleado123',
            'role' => 'empleado',
        ]);

    }
}
