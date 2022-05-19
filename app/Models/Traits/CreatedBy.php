<?php
namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait CreatedBy
{

    public static function bootCreatedBy()
    {
        static::creating(function($model) {

            if(is_null($model->created_by)) {

                $model->created_by = Auth::user()->id;
            }
        });
    }

    /**
     * Author
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
