<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $roleAdmin = Role::where('name', 'admin')->firstOrFail();

        User::updateOrCreate(
            ['email' => 'admin@sigae.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12312318'),
                'role_id' => $roleAdmin->id,
            ]
        );
    }
}