<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserHasRole;
use Database\Seeders\IssueCategorySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmployeeLevelSeeder::class,
            RoleSeeder::class,
            DepartmentSeeder::class,
            RequestingBranchSeeder::class,
            IssueCategorySeeder::class
        ]);
       
    }
}
