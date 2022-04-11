<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Parent comment
     */
    public function parent()
    {
        return $this->hasOne(self::class);
    }

    /**
     * Children comment
     */
    public function children()
    {
        return $this->hasMany(self::class);
    }

    /**
     * Latest child comment
     */
    public function latestChild()
    {
        return $this->hasOne(self::class)->latestOfMany();
    }
}
