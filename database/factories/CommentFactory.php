<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'body' => $this->faker->text(),
        ];
    }

    public function levelTwo()
    {
        return $this->state(function (array $attributes) {

            $comment = Comment::whereNull('parent_id')->inRandomOrder()->first();

            return [
                'parent_id' => $comment->id,
            ];
        });
    }

    public function levelThree()
    {
        return $this->state(function (array $attributes) {

            $comment = Comment::whereNotNull('parent_id')->inRandomOrder()->first();

            return [
                'parent_id' => $comment->id,
            ];
        });
    }
}
