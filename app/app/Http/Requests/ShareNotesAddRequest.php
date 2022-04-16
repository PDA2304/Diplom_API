<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareNotesAddRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_sender' => ['required'],
            'user_receiver' => ['required'],
            'notes_id' => ['required'],
        ];
    }
}
