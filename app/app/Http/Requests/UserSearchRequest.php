<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSearchRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'type_table' => 'required|integer',
            'search' => 'required',
            'data_id' => 'required|integer',
        ];
    }
}
