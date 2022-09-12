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
        $users = User::all(['id']);
        $pending = false;
        $i = 0;
        while ($users->count() > 1 && $i <= $users->count()) {
            $i++;
            $userId = $users->random();
            $users->pull($userId->getKey());

            // Get random user and remove from collection
            $friendId = $users->random();
            $users->pull($friendId->getKey());

            UserRequest::create([
                'sender_id' => $userId->getKey(),
                'receiver_id' => $friendId->getKey(),
                'status'   => $pending
            ]);

            $pending = !$pending;
        }


    }
}
