<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stamps')->insert([
            [
                'user_id' => 1,
                'start_work' => '9:00:00',
                'end_work' => '17:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/16',
                'created_at' => '2021/10/16 11:11:11',
            ],
            [
                'user_id' => 2,
                'start_work' => '8:00:00',
                'end_work' => '17:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/16',
                'created_at' => '2021/10/16 11:11:11'
            ],
            [
                'user_id' => 3,
                'start_work' => '7:00:00',
                'end_work' => '16:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/16',
                'created_at' => '2021/10/16 11:11:11'
            ],
            [
                'user_id' => 4,
                'start_work' => '8:00:00',
                'end_work' => '16:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/16',
                'created_at' => '2021/10/16 11:11:11'
            ],
            [
                'user_id' => 5,
                'start_work' => '9:00:00',
                'end_work' => '17:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/16',
                'created_at' => '2021/10/16 11:11:11'
            ],
            [
                'user_id' => 6,
                'start_work' => '8:00:00',
                'end_work' => '16:00:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/17',
                'created_at' => '2021/10/17 11:11:11'
            ],
            [
                'user_id' => 1,
                'start_work' => '9:30:00',
                'end_work' => '17:30:00',
                'total_rest' => '01:00:00',
                'total_work' => '07:00:00',
                'stamp_date' => '2021/10/17',
                'created_at' => '2021/10/17 11:11:11'
            ],
        ]);
    }
}
