<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Http\Response;

class ThreadTest extends TestCase
{
    public const PAYLOAD = [
        'body' => 'Test Thread'
    ];

    /**
     * Publish a thread.
     *
     * @return void
     */
    public function test_post_a_thread()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->json('POST', route('thread.create'), self::PAYLOAD)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View threads
     */
    public function test_view_threads()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->json('GET', route('thread.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Allow replies on threads
     */
    public function test_post_a_thread_reply()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $thread = Thread::factory()->create([
            'created_by' => $user->id
        ]);

        $this->json('POST', route('thread-reply.create', ['thread' => $thread]), ['body' => 'test_post_a_thread_reply'])
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View replies
     */
    public function test_view_replies()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $thread = Thread::factory()->create([
            'created_by' => $user->id
        ]);

        $this->json('GET', route('thread-reply.index', ['thread' => $thread]))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Expect 403 if level exceeds limit
     */
    public function test_limit_thread_replies()
    {
        $thread = null;

        if($threadMaxLevel = config('thread.thread_max_level') === NULL) {

            return $this->assertTrue(true);
        }

        $user = User::factory()->create();

        $this->actingAs($user);

        // Dynamically adjust level depending on config
        for ($i = 0; $i < $threadMaxLevel ; $i++) {

            $thread = Thread::factory()->create([
                'created_by' => $user->id,
                'parent_id' => $thread?->id,
            ]);
        }

        $this->json('POST', route('thread-reply.create', ['thread' => $thread]), ['body' => 'test_limit_thread_replies'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
