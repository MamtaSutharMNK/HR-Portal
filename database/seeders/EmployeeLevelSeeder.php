<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee_levels')->insert([
            ['title' => 'Associate I (0–2 yrs)'],
            ['title' => 'Associate II (1–3 yrs)'],
            ['title' => 'Associate III (2–4 yrs)'],
            ['title' => 'Technical Lead (3–5 yrs)'],
            ['title' => 'Quality Lead (3–5 yrs)'],
            ['title' => 'Team Lead (7–10 yrs)'],
            ['title' => 'Process Expert (5–7 yrs)'],
            ['title' => 'Manager (7–10 yrs)'],
            ['title' => 'Senior Manager (10–13 yrs)'],
            ['title' => 'Divisional Head I (13–15 yrs)'],
            ['title' => 'Divisional Head II (15–18 yrs)'],
            ['title' => 'Location Head (18+ yrs)'],
        ]);
    }
}
