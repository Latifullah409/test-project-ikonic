<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRequest::factory()->count(100)->create();
    }
}
