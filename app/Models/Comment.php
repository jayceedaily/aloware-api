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
      * Children comment
      *
      * @return HasMany
      */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

     /**
      * Latest child comment
      *
      * @return HasOne
      * @throws InvalidArgumentException
      */
    public function latestChild()
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
        return Cache::remember('cmt-lvl-' . $this->id, 300, function () {

            return DB::select("

            WITH RECURSIVE cte AS (
                SELECT
                    1 AS lvl,
                    parent_id,
                    id
                FROM
                    comments

                UNION ALL
                SELECT
                    lvl + 1,
                    comments.parent_id,
                    comments.id
                FROM
                    comments
                    JOIN cte ON comments.parent_id = cte.id
            )

            SELECT
                MAX(lvl) AS depth
            FROM
                cte
                where id = ?
                ;", [$this->id])[0]->depth;
        });
    }
}
