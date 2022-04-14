<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SingUpRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'user_name' => ["required", "min:3", "max:30"],
            'login' => ["required", "email:rfc,dns", function ($attribute, $value, $fail) {
                if (User::where('login', '=', $value)->first()) {
                    $fail('Taкая почта есть в системе');
                }
            }],
            'password' => ["required", 'min:8', "max:16"]
        ];
    }

    public function attributes()
    {
        return [
            "user_name" => 'имя пользователя',
            "login" => 'логин',
            "password" => 'пароль',
        ];
    }
}
