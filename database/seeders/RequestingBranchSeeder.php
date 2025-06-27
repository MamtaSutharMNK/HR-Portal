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
        ['name' => 'SMGA UK', 'branch_code' => 'uk'],
        ['name' => 'SMGA ITALY', 'branch_code' => 'it'],
        ['name' => 'SMGA Texas', 'branch_code' => 'tx'],
        ['name' => 'SMGA Africa & Middle East', 'branch_code' => 'AF'],
    ]);

    }
}
