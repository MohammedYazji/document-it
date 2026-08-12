<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate([
            'name' => 'Admin',
        ], [
            'abilities' => ['view', 'create', 'update', 'delete'],
        ]);

        Role::firstOrCreate([
            'name' => 'Editor',
        ], [
            'abilities' => ['view', 'create', 'update'],
        ]);

        Role::firstOrCreate([
            'name' => 'Moderator',
        ], [
            'abilities' => ['view', 'update'],
        ]);

        Role::firstOrCreate([
            'name' => 'Author',
        ], [
            'abilities' => ['view'],
        ]);
    }
}
