<?php

namespace Database\Seeders;

use App\Models\Comment;
use Database\Factories\CommentFactory;
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
        echo 'SEEDING LEVEL 1 COMMENTS' . PHP_EOL;
        Comment::factory(100)->create();

        echo 'SEEDING LEVEL 2 COMMENTS' . PHP_EOL;
        Comment::factory(1000)->levelTwo()->create();

        echo 'SEEDING LEVEL 3 COMMENTS' . PHP_EOL;
        Comment::factory(10000)->levelThree()->create();
    }
}
