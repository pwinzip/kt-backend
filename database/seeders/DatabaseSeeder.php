<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersSeeder::class);
        // $this->call(EnterprisesSeeder::class);
        // $this->call(FarmersSeeder::class);
        // $this->call(OrdersSeeder::class);
        // $this->call(OrderDetailsSeeder::class);
    }
}
