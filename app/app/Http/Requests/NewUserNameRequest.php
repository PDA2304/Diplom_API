<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserNameRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'user_name' => ['required', 'min:3', 'max:30']
        ];
    }
}
