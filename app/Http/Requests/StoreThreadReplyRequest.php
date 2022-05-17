<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest;
use App\Http\Requests\StoreThreadRequest;

class StoreThreadReplyRequest extends FormRequest
{
    /**
     * Allow N number of level for thread replies
     *
     * @return bool
     */
    public function authorize()
    {
        $threadLevel       = $this->route('thread')->getLevel();

        $threadMaxLevel    = config('thread.thread_max_level');

        return  $threadLevel < $threadMaxLevel;
    }

    /**
     * Duplicate rules from StoreThreadRequest
     *
     * @return array
     */
    public function rules()
    {
        return (new StoreThreadRequest)->rules();
    }
}
