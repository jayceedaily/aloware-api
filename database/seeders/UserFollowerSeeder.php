<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserFollower;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $followers = User::inRandomOrder()->limit(100)->get();

        $connections = [];

        $datetime = now();

        foreach ($followers as $follower) {

            $followings = User::inRandomOrder()
                                ->where('id', '!=', $follower->id)
                                ->limit(\rand(1,100))
                                ->get();

            foreach ($followings as $following) {

                array_push($connections,[
                    'follower_id'   => $follower->id,
                    'following_id'  => $following->id,
                    'created_at'    => $datetime,
                    'updated_at'    => $datetime,
                ]);
            }
        }

        UserFollower::insert($connections);
    }
}
