<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Saad',
            'email' => 'saad@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Jamil',
            'email' => 'jamil@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Ikram',
            'email' => 'ikram2k22@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Jamal',
            'email' => 'jamal@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'khan',
            'email' => 'khan123@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Latif',
            'email' => 'latif1245@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Said Zamin',
            'email' => 'said.zamin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Kashif',
            'email' => 'kashif@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Muhammad Uzair',
            'email' => 'uzair@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        User::create([
            'name' => 'Akram',
            'email' => 'akram.khan@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
