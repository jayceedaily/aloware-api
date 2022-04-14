<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'body'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // protected $withCount = ['replies'];

     /**
      * Parent comment
      *
      * @return HasOne
      */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

     /**
      * replies comment
      *
      * @return HasMany
      */
    public function replies()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

     /**
      * Latest child comment
      *
      * @return HasOne
      * @throws InvalidArgumentException
      */
    public function latestReply()
    {
        return $this->hasOne(self::class, 'parent_id')->latestOfMany();
    }

     /**
      * Get depth of comment
      *
      * @return mixed
      */
    public function getLevel()
    {
        return DB::select("

        with recursive CommentTree (id, parent_id, level) as (
            select
                id,
                parent_id,
                0 as level
            from
                comments
            where
                id = ?

            union all

            select
                c.id,
                c.parent_id,
                ct.level + 1
            from
                CommentTree ct
                join comments c on (c.id = ct.parent_id)
        )
        select
            COUNT(*) as depth
        from
            CommentTree

            limit 1;
            ;", [$this->id])[0]->depth;
    }
}
