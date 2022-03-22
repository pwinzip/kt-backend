<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FarmersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('farmers')->delete();

        $data = [
            [
                "user_id"=> 3,
                'address' => 'Stingpra',
                'growing_area' => 1,
                'lat_plot' => 7.556450,
                'long_plot' => 100.413495,
                'received_amount' => 50,
                'enterprise_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "user_id"=> 4,
                'address' => 'Stingpra',
                'growing_area' => 20,
                'lat_plot' => 7.556450,
                'long_plot' => 100.413495,
                'received_amount' => 100,
                'enterprise_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('farmers')->insert($data);
    }
}
