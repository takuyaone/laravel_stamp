<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rests')->insert([
            [
                'stamp_id' => 1,
                'rest_start' => '12:00:00',
                'rest_end' => '13:00:00',
                'rest_time' => 3600,
            ],
            [
                'stamp_id' => 1,
                'rest_start' => '13:30:00',
                'rest_end' => '14:00:00',
                'rest_time' => 3600,
            ],

            [
                'stamp_id' => 2,
                'rest_start' => '12:00:00',
                'rest_end' => '13:15:00',
                'rest_time' => 2400,
            ],
            // [
            //     'stamp_id' => 3,
            //     // 'rest_start' => '12:00:00',
            //     // 'rest_end' => '13:30:00',
            //     // 'rest_time' => '01:30:00',
            // ],
            // [
            //     'stamp_id' => 4,
            //     // 'rest_start' => '12:15:00',
            //     // 'rest_end' => '13:00:00',
            //     // 'rest_time' => '00:45:00',
            // ],
            // [
            //     'stamp_id' => 5,
            //     // 'rest_start' => '11:00:00',
            //     // 'rest_end' => '12:00:00',
            //     // 'rest_time' => '01:00:00',
            // ],
            // [
            //     'stamp_id' => 6,
            //     // 'rest_start' => '12:00:00',
            //     // 'rest_end' => '13:00:00',
            //     // 'rest_time' => '01:00:00',
            // ],
            // [
            //     'stamp_id' => 7,
            //     // 'rest_start' => '12:00:00',
            //     // 'rest_end' => '13:30:00',
            //     // 'rest_time' => '01:30:00',
            // ],
            // [
            //     'stamp_id' => 8,
            //     // 'rest_start' => '12:00:00',
            //     // 'rest_end' => '13:00:00',
            //     // 'rest_time' => '01:00:00',
            // ],
            // [
            //     'stamp_id' => 1,
            //     // 'rest_start' => '13:30:00',
            //     // 'rest_end' => '14:00:00',
            //     'rest_time' => '01:00:00',
            // ],
            // [
            //     'stamp_id' => 8,
            //     // 'rest_start' => '13:15:00',
            //     // 'rest_end' => '13:45:00',
            //     'rest_time' => '01:00:00',
            // ],


        ]);
    }
}
