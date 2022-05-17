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
        $date = Carbon::today()->subMinutes(rand(0, 525600));

        $user = User::inRandomOrder()->first();

        return [
            'created_by' => $user->id,
            'body'       => $this->faker->text(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }

    /**
     * Create level 2 threads
     *
     * i.e: threads->threads
     *
     * @return static
     */
    public function levelTwo()
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

    /**
     * Create level 3 threads
     *
     * i.e. threads->threads->threads
     *
     * @return static
     */
    public function levelThree()
    {
        return $this->state(function (array $attributes) {

            $thread = Thread::whereNotNull('parent_id')->inRandomOrder()->first();

            $replyGap = $thread->created_at->diffInMinutes(Carbon::now());

            $date = $thread->created_at->clone()->addMinutes(rand(ceil($replyGap/2), $replyGap));

            return [
                'parent_id' => $thread->id,
                'created_at' => $date,
                'updated_at' => $date,
            ];
        });
    }
}
