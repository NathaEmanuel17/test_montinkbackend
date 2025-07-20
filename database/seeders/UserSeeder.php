<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create([
            'role' => 'admin',
        ]);

        // 20 Clientes
        User::factory()->count(20)->create([
            'role' => 'client',
        ]);

        // Usuário fixo de teste (opcional)
        User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@teste.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
