<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserShareRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'type_table_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'data_id' => ['required', 'integer'],
        ];
    }
}
