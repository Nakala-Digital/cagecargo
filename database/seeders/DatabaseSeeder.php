<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Operasional User', 'email' => 'ops@cargogate.com', 'role' => 'operasional', 'phone' => null],
            ['name' => 'Finance User', 'email' => 'finance@cargogate.com', 'role' => 'finance', 'phone' => null],
            ['name' => 'PPJK User', 'email' => 'ppjk@cargogate.com', 'role' => 'ppjk', 'phone' => null],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                    'phone' => $user['phone'],
                ]
            );
        }

        $this->call(DemoPresentationSeeder::class);
    }
}
