<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Disable validation redirect and return
     * JSON valdiation errors
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
