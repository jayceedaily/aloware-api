<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use App\Http\Requests\StoreCommentRequest;

class StoreCommentReplyRequest extends FormRequest
{
    /**
     * Allow N number of level for comment replies
     *
     * @return bool
     */
    public function authorize()
    {
        $commentLevel       = $this->route('comment')->getLevel();

        $commentMaxLevel    = config('comment.comment_max_level');

        return  $commentLevel < $commentMaxLevel;
    }

    /**
     * Duplicate rules from StoreCommentRequest
     *
     * @return array
     */
    public function rules()
    {
        return (new StoreCommentRequest)->rules();
    }
}
