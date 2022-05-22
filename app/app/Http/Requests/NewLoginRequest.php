<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class NewLoginRequest extends ApiRequest
{

    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'login' => ["required", "email:rfc", function ($attribute, $value, $fail) {
                if (User::where('login', '=', $value)->first()) {
                    $fail('Taкая почта есть в системе');
                }
            }]
        ];
    }
}
