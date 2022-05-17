<?php

namespace App\Models;

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
    use HasFactory;

    protected $fillable = ['name', 'body'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // protected $withCount = ['replies'];

    /**
     * Author
     *
     * @return BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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
