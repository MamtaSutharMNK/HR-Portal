<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RequestingBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('requesting_branches')->insert([
        ['name' => 'MNK INTERNATIONAL', 'branch_code' => 'NULL'],
        ['name' => 'SPECIALTY MGA', 'branch_code' => 'NULL'],
        ['name' => 'MNK GCS', 'branch_code' => 'NULL'],
        ['name' => 'MEKONG RE', 'branch_code' => 'NULL'],
        ['name' => 'MNK SEGUROS', 'branch_code' => 'NULL'],
        ['name' => 'FLORIDA RE', 'branch_code' => 'NULL']
    ]);

    }
}
