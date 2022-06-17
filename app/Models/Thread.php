<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Thread extends Model
{
    use HasFactory, CreatedBy;

    protected $fillable = ['name', 'body', 'parent_id', 'created_by'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // protected $withCount = ['replies'];


     /**
      * Parent thread
      *
      * @return HasOne
      */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    /**
     * Child thread
     *
     * @return HasMany
     */
    public function child()
    {
        return $this->hasMany(self::class);
    }

    public function shared()
    {
        return $this->hasOne(self::class,'id', 'child_id');
    }

     /**
      * replies thread
      *
      * @return HasMany
      */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

     /**
      * Latest child thread
      *
      * @return HasOne
      * @throws InvalidArgumentException
      */
    public function latestReply()
    {
        return $this->hasOne(self::class, 'parent_id')->latestOfMany();
    }

    /**
     *
     * @param mixed $query
     * @param mixed $user
     * @return mixed
     */
    public function scopeFromFollowing($query, $user)
    {
        return $query
                    ->selectRaw('threads.*, thread_likes.user_id is not null as liked')
                    ->join('user_followers', 'threads.created_by','=','user_followers.following_id')
                    ->leftJoin('thread_likes', function($on) use ($user) {
                        $on->whereColumn('thread_likes.thread_id', 'threads.id')
                            ->where('thread_likes.user_id', $user->id);
                    })
                    ->where('threads.created_by', $user->id)
                    ->orWhere('follower_id', $user->id);
    }

    public function likes()
    {
        return $this->hasMany(ThreadLike::class);
    }

     /**
      * Get depth of thread
      *
      * @return mixed
      */
    public function getLevel()
    {
        return DB::select("

        with recursive ThreadTree (id, parent_id, level) as (
            select
                id,
                parent_id,
                0 as level
            from
                threads
            where
                id = ?

            union all

            select
                c.id,
                c.parent_id,
                ct.level + 1
            from
                ThreadTree ct
                join threads c on (c.id = ct.parent_id)
        )
        select
            COUNT(*) as depth
        from
            ThreadTree

            limit 1;
            ;", [$this->id])[0]->depth;
    }
}
