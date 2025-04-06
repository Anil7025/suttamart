<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dp__statuses')->insert([
            [
                'id' => 1,
                'status' => 'Publish',
                'created_at' => Carbon::create(2021, 5, 1, 4, 46, 48),
                'updated_at' => Carbon::create(2021, 5, 1, 4, 46, 50),
            ],
            [
                'id' => 2,
                'status' => 'Draft',
                'created_at' => Carbon::create(2021, 5, 1, 4, 47, 5),
                'updated_at' => Carbon::create(2021, 5, 1, 4, 47, 6),
            ],
        ]);
    }
}
