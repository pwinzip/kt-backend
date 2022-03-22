<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class EnterprisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('enterprises')->delete();

        $data = [
            [
                "regist_no"=> "PHL001",
                'enterprise_name' => 'enterprise test',
                'agent_id' => 1,
                'address' => "Songkhla",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('enterprises')->insert($data);
    }
}
