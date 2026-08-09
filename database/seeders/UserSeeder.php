<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->delete();

        // Admin
        $admin = User::create([
            'name' => 'Mohammed Yazji',
            'email' => 'mw.alyazji@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'username' => 'myazji',
            'type' => 'super-admin',
        ]);

        $adminRole = \App\Models\Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $admin->roles()->attach($adminRole);
        }

        // Regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'username' => 'johndoe',
            'type' => 'user',
        ]);
    }
}
