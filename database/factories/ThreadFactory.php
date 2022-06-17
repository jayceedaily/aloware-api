<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = Carbon::today()->subMinutes(rand(0, 1440));

        $user = User::inRandomOrder()->first();

        return [
            'created_by' => $user->id,
            'body'       => $this->faker->text(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    public function share()
    {
        return $this->state(function (array $attributes) {

            $thread = Thread::whereNotNull('body')->inRandomOrder()->first();

            $user = User::find($attributes['created_by']);

            if (!$user->threadLikes()->where('thread_id', $thread->id)->exists()) {

                $user->threadLikes()->create([
                    'thread_id' => $thread->id
                ]);
            }

            $date = $thread->created_at->addMinutes(rand(0, 1440));

            return [
                'body'       => $this->faker->sentence(),
                'created_at' => $date,
                'updated_at' => $date,
                'child_id'   => $thread?->id
            ];
        });
    }

    public function retweet()
    {
        return $this->state(function (array $attributes) {

            $thread = Thread::whereNull('parent_id')->inRandomOrder()->first();

            $date = $thread->created_at->addMinutes(rand(0, 1440));

            return [
                'body'       => null,
                'created_at' => $date,
                'updated_at' => $date,
                'child_id'   => $thread?->id
            ];
        });
    }

    /**
     * Create level 2 threads
     *
     * i.e: threads->threads
     *
     * @return static
     */
    public function reply()
    {
        return $this->state(function (array $attributes) {

            $thread = Thread::whereNull('parent_id')->inRandomOrder()->first();

            $replyGap = $thread->created_at->diffInMinutes(Carbon::now());

            $date = $thread->created_at->addMinutes(rand(0, $replyGap));

            return [
                'parent_id' => $thread->id,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
