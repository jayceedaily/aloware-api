<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Comment;

class CommentTest extends TestCase
{
    public const PAYLOAD = [
        'name' => 'John Doe',
        'body' => 'Test Comment'
    ];

    /**
     * Publish a comment.
     *
     * @return void
     */
    public function test_post_a_comment()
    {
        $this->json('POST', route('post-comment.create'), self::PAYLOAD)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View comments
     */
    public function test_view_comments()
    {
        $this->json('GET', route('post-comment.index'))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Allow replies on comments
     */
    public function test_post_a_comment_reply()
    {
        $comment = Comment::factory()->create();

        $this->json('POST', route('comment-reply.create', ['comment' => $comment]), self::PAYLOAD)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * View replies
     */
    public function test_view_replies()
    {
        $comment = Comment::factory()->create();

        $this->json('GET', route('comment-reply.index', ['comment' => $comment]))
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Expect 403 if level exceeds limit
     */
    public function test_limit_comment_replies()
    {
        $comment = Comment::factory()->create();

        // Dynamically adjust level depending on config
        for ($i=1; $i < config('comment.comment_max_level') ; $i++) {
            $comment = Comment::factory()->create(['parent_id' => $comment->id]);
        }

        $this->json('POST', route('comment-reply.create', ['comment' => $comment]), self::PAYLOAD)
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
