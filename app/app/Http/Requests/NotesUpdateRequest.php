<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotesUpdateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'notes_name' => ['required','max:30'],
            'content' => ['required'],
            'description' => ['max:255']
        ];
    }

    public function attributes()
    {
        return [
            "notes_name"=>'название',
            "content"=>'содержание',
            "description"=>'описание',
        ];
    }
}
