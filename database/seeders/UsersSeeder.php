<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $data = [
            [
                "name"=> "admin",
                'password' => Hash::make('123456'),
                'tel' => "0887607910",
                'role' => 0, // admin
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "name"=> "enterprise one",
                'password' => Hash::make('123456'),
                'tel' => "0887607910",
                'role' => 1, // enterprise
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "name"=> "farmer one",
                'password' => Hash::make('123456'),
                'tel' => "0897374984",
                'role' => 2, // farmer
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                "name"=> "farmer two",
                'password' => Hash::make('123456'),
                'tel' => "0894623275",
                'role' => 2, // farmer
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
