<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::factory()->create([
            'name' => 'Administrador'
        ]);
        Role::factory()->create([
            'name' => 'Profesor'
        ]);
        Role::factory()->create([
            'name' => 'Estudiante'
        ]);
        User::factory()->create([
            'name' => 'Luis Martin',
            'lastname' => 'Vilca Hilasaca',
            'email' => 'luis@gmail.com',
            'username' => 'luis.vilca',
            'state' => 1,
            'type_user' => 1,
            'role_id' => 1,
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);
    }
}
