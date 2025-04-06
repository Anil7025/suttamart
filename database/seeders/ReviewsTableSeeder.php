<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            ['id' => 1, 'item_id' => 1, 'user_id' => 1, 'rating' => 3, 'comments' => 'Good Product', 'created_at' => Carbon::parse('2025-03-11 23:15:09'), 'updated_at' => Carbon::parse('2025-03-11 23:15:09')],
            ['id' => 2, 'item_id' => 2, 'user_id' => 1, 'rating' => 5, 'comments' => 'Nice Product', 'created_at' => Carbon::parse('2025-03-11 23:15:14'), 'updated_at' => Carbon::parse('2025-03-11 23:15:14')],
            ['id' => 3, 'item_id' => 3, 'user_id' => 1, 'rating' => 5, 'comments' => 'Nice', 'created_at' => Carbon::parse('2025-03-11 23:15:18'), 'updated_at' => Carbon::parse('2025-03-11 23:15:18')],
            ['id' => 4, 'item_id' => 4, 'user_id' => 1, 'rating' => 5, 'comments' => 'Best Item', 'created_at' => Carbon::parse('2025-03-11 23:15:23'), 'updated_at' => Carbon::parse('2025-03-11 23:15:23')],
            ['id' => 5, 'item_id' => 5, 'user_id' => 1, 'rating' => 2, 'comments' => 'Nice Item, I will buying next time', 'created_at' => Carbon::parse('2025-03-11 23:15:51'), 'updated_at' => Carbon::parse('2025-03-11 23:15:51')],
            ['id' => 6, 'item_id' => 6, 'user_id' => 1, 'rating' => 1, 'comments' => 'Nice', 'created_at' => Carbon::parse('2025-03-11 23:15:56'), 'updated_at' => Carbon::parse('2025-03-11 23:15:56')],
            ['id' => 7, 'item_id' => 7, 'user_id' => 1, 'rating' => 5, 'comments' => 'wow', 'created_at' => Carbon::parse('2025-03-11 23:16:05'), 'updated_at' => Carbon::parse('2025-03-11 23:16:05')],
            ['id' => 8, 'item_id' => 8, 'user_id' => 1, 'rating' => 5, 'comments' => 'Best', 'created_at' => Carbon::parse('2025-03-11 23:16:11'), 'updated_at' => Carbon::parse('2025-03-11 23:16:11')],
            ['id' => 9, 'item_id' => 9, 'user_id' => 1, 'rating' => 5, 'comments' => 'Nice Item, I will buying next time', 'created_at' => Carbon::parse('2025-03-11 23:16:41'), 'updated_at' => Carbon::parse('2025-03-11 23:16:41')],
            ['id' => 10, 'item_id' => 10, 'user_id' => 1, 'rating' => 5, 'comments' => null, 'created_at' => Carbon::parse('2025-03-11 23:16:45'), 'updated_at' => Carbon::parse('2025-03-11 23:16:45')],
            ['id' => 11, 'item_id' => 11, 'user_id' => 1, 'rating' => 5, 'comments' => null, 'created_at' => Carbon::parse('2025-03-11 23:16:48'), 'updated_at' => Carbon::parse('2025-03-11 23:16:48')],
            ['id' => 12, 'item_id' => 12, 'user_id' => 1, 'rating' => 5, 'comments' => 'Nice Item, I will buying next time', 'created_at' => Carbon::parse('2025-03-11 23:16:52'), 'updated_at' => Carbon::parse('2025-03-11 23:16:52')],
            ['id' => 13, 'item_id' => 13, 'user_id' => 1, 'rating' => 5, 'comments' => null, 'created_at' => Carbon::parse('2025-03-11 23:16:57'), 'updated_at' => Carbon::parse('2025-03-11 23:16:57')],
            ['id' => 14, 'item_id' => 14, 'user_id' => 1, 'rating' => 5, 'comments' => 'Nice Product', 'created_at' => Carbon::parse('2025-03-11 23:17:21'), 'updated_at' => Carbon::parse('2025-03-11 23:17:21')],
            ['id' => 15, 'item_id' => 15, 'user_id' => 1, 'rating' => 5, 'comments' => 'food products are often laden with bacterial and', 'created_at' => Carbon::parse('2022-08-08 11:54:42'), 'updated_at' => Carbon::parse('2022-08-08 11:54:42')],
            ['id' => 16, 'item_id' => 16, 'user_id' => 1, 'rating' => 5, 'comments' => 'test', 'created_at' => Carbon::parse('2025-03-11 10:03:28'), 'updated_at' => Carbon::parse('2025-03-11 10:03:28')],
            ['id' => 17, 'item_id' => 17, 'user_id' => 1, 'rating' => 5, 'comments' => 'test', 'created_at' => Carbon::parse('2025-03-11 10:03:52'), 'updated_at' => Carbon::parse('2025-03-11 10:03:52')],
            ['id' => 18, 'item_id' => 18, 'user_id' => 2, 'rating' => 5, 'comments' => 'Test', 'created_at' => Carbon::parse('2025-03-11 17:14:43'), 'updated_at' => Carbon::parse('2025-03-11 17:14:45')],
            ['id' => 19, 'item_id' => 1, 'user_id' => 2, 'rating' => 5, 'comments' => 'food products are often laden with bacterial and', 'created_at' => Carbon::parse('2025-03-11 17:15:51'), 'updated_at' => Carbon::parse('2025-03-11 17:15:52')],
            ['id' => 20, 'item_id' => 1, 'user_id' => 1, 'rating' => 5, 'comments' => 'Vegetables are parts of plants that are consumed by humans or other animals as food.', 'created_at' => Carbon::parse('2025-03-11 11:33:34'), 'updated_at' => Carbon::parse('2025-03-11 11:33:34')],
            ['id' => 21, 'item_id' => 1, 'user_id' => 1, 'rating' => 5, 'comments' => 'f', 'created_at' => Carbon::parse('2025-03-11 10:38:32'), 'updated_at' => Carbon::parse('2025-03-11 10:38:32')],
        ]);
    }
}
