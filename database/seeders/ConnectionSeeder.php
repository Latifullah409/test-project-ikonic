<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConnectionSeeder::create([
            'name' => 'Hardik',
            'email' => 'admin@gmail.com',
            'status' => bcrypt('123456'),
        ]);
    }
}
