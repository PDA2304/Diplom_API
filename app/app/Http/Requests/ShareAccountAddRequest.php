<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareAccountAddRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_sender' => ['required'],
            'user_receiver' => ['required'],
            'account_id' => ['required'],
        ];
    }
}
