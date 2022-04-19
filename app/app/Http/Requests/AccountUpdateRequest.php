<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'id'=>['required'],
            'account_name' => ['required', 'max:30'],
            'login' => ['required', 'max:30'],
            'password' => ['required',],
            'description' => ['max:255'],
        ];
    }
}
