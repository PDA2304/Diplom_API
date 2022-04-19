<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareAccountRemoveRequest extends FormRequest
{
       public function rules()
    {
        return [
            'notes_id' => ['required'],
            'user_receiver_id' => ['required'],
        ];
    }
}
