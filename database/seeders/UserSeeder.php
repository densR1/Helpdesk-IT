<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cari role berdasarkan name
        $adminRole = Role::where('name', 'admin')->first();
        $agentRole = Role::where('name', 'agent')->first();
        $userRole = Role::where('name', 'user')->first();

        // Bikin user dengan role_id
        User::create([
            'name' => 'Admin',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Agent 1',
            'email' => 'agent@helpdesk.com',
            'password' => Hash::make('password'),
            'role_id' => $agentRole->id,
        ]);

        User::create([
            'name' => 'User Demo',
            'email' => 'user@helpdesk.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
        ]);
    }
}
