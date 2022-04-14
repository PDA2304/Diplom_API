<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SingInRequest extends ApiRequest
{
    
    public function rules()
    {
        return [
            'login' => ["required", "min:3", "max:30", function ($attribute, $value, $fail) {
                if (!User::where('login', '=', $value)->first()) {
                    $fail('Такого логина нет в системе');
                }
            }],
            'password' => ["required", "max:16"]
        ];
    }

    public function attributes()
    {
        return [
            "login"=>'логин',
            "password"=>'пароль',
        ];
    }
}
