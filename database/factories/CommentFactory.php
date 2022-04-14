<?php

namespace Database\Factories;

use App\Models\Comment;
use Carbon\Carbon;
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
        $date = Carbon::today()->subMinutes(rand(0, 525600));

        return [
            'name' => $this->faker->name(),
            'body' => $this->faker->text(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    /**
     * Create level 2 comments
     *
     * i.e: comments->comments
     *
     * @return static
     */
    public function levelTwo()
    {
        return $this->state(function (array $attributes) {

            $comment = Comment::whereNull('parent_id')->inRandomOrder()->first();

            $replyGap = $comment->created_at->diffInMinutes(Carbon::now());

            $date = $comment->created_at->addMinutes(rand(0, $replyGap));

            return [
                'parent_id' => $comment->id,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }

    /**
     * Create level 3 comments
     *
     * i.e. comments->comments->comments
     *
     * @return static
     */
    public function levelThree()
    {
        return $this->state(function (array $attributes) {

            $comment = Comment::whereNotNull('parent_id')->inRandomOrder()->first();

            $replyGap = $comment->created_at->diffInMinutes(Carbon::now());

            $date = $comment->created_at->clone()->addMinutes(rand(ceil($replyGap/2), $replyGap));

            return [
                'parent_id' => $comment->id,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
