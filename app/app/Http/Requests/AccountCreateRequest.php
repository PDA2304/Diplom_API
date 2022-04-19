<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountCreateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'account_name' => ['required', 'max:30'],
            'login' => ['required', 'max:30'],
            'password' => ['required',],
            'description' => ['max:255'],
            'user_id' => ['required'],
        ];
    }
}
