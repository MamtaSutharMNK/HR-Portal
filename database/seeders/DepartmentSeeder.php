<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->delete();
        DB::statement('ALTER TABLE departments AUTO_INCREMENT = 1');

        DB::table('departments')->insert([
            ['name' => 'Admin'],
            ['name' => 'Broker Solutions'],
            ['name' => 'DevOps'],
            ['name' => 'Finance Operations'],
            ['name' => 'Human Resource Management'],
            ['name' => 'IT Analyst'],
            ['name' => 'IT Qulaity Testing'],
            ['name' => 'IT Support'],
            ['name' => 'Software Developer'],
            ['name' => 'Management & Administration'],
            ['name' => 'Risk Management'],
            ['name' => 'Underwriting Operations-CAT Brain'],
            ['name' => 'Underwriting Support Solutions'],
            ['name' => 'Compliance'],
        ]);
    }
}
