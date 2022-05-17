<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Thread;

class ThreadTest extends TestCase
{
    public const PAYLOAD = [
        'name' => 'John Doe',
        'body' => 'Test Thread'
    ];

    /**
     * Publish a thread.
     *
     * @return void
     */
    public function test_post_a_thread()
    {
        $this->json('POST', route('post-thread.create'), self::PAYLOAD)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View threads
     */
    public function test_view_threads()
    {
        $this->json('GET', route('post-thread.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Allow replies on threads
     */
    public function test_post_a_thread_reply()
    {
        $thread = Thread::factory()->create();

        $this->json('POST', route('thread-reply.create', ['thread' => $thread]), self::PAYLOAD)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View replies
     */
    public function test_view_replies()
    {
        $thread = Thread::factory()->create();

        $this->json('GET', route('thread-reply.index', ['thread' => $thread]))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Expect 403 if level exceeds limit
     */
    public function test_limit_thread_replies()
    {
        $thread = Thread::factory()->create();

        // Dynamically adjust level depending on config
        for ($i=1; $i < config('thread.thread_max_level') ; $i++) {
            $thread = Thread::factory()->create(['parent_id' => $thread->id]);
        }

        $this->json('POST', route('thread-reply.create', ['thread' => $thread]), self::PAYLOAD)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
