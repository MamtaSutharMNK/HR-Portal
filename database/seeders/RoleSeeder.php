<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\UserHasRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name'   => 'Admin',
            'email'  => 'SupportAdmin@mnkgcs.com',
            'emp_id' => 1,
            'password' => '$2y$10$QvI2q9405VHKNyN2ZfCeeOPhMhGz2m/8OipUgassSvZu5W7DGCIjC'
        ]);

        UserHasRole::insert([
            'user_id' => 1,
            'role_id' =>1
        ]);

        Role::insert([
            'name' => 'Admin',
        ],[
            'name' => 'User',
        ]);
    }
}
