<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
            'old_password' => ['required'],
            'new_password' => ['required', 'different:old_password', 'min:8', "max:16"],
        ];
    }

    public function attributes()
    {
        return [
            "old_password" => 'старый пароль',
            "new_password" => 'новый пароль',
        ];
    }
}
