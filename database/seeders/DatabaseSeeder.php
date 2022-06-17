<?php

namespace Database\Seeders;

use App\Models\Thread;
use App\Models\User;
use App\Models\UserFollower;
use Database\Factories\ThreadFactory;
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
        // echo 'SEEDING USERS' . PHP_EOL;
        // User::factory(10)->create();

        // echo 'SEEDING FOLLOWERS' . PHP_EOL;
        // $this->call(UserFollowerSeeder::class);

        echo 'SEEDING TWEETS' . PHP_EOL;
        Thread::factory(100)->create();

        echo 'SEEDING RETWEET' . PHP_EOL;
        Thread::factory(100)->retweet()->create();

        echo 'SEEDING REPLY' . PHP_EOL;
        Thread::factory(100)->reply()->create();

        echo 'SEEDING SHARE' . PHP_EOL;
        Thread::factory(100)->share()->create();
    }
}
