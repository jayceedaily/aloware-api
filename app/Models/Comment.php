<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'body'];

    /**
     * Parent comment
     */
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    /**
     * Children comment
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Latest child comment
     */
    public function latestChild()
    {
        return $this->hasOne(self::class, 'parent_id')->latestOfMany();
    }

    /**
     * Get depth of comment
     */
    public function getLevel()
    {
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
    }
}
