<?php

namespace App\Http\Requests;

use App\Models\Notes;
use Illuminate\Foundation\Http\FormRequest;

class NotesCreateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'notes_name' => ['required','max:30',function ($attribute, $value, $fail) {
                if (Notes::where('user_id', '=', $this->user_id)->where('notes_name','=',$value)->first()) {
                    $fail('Заметка с таким названием уже существует');
                }
            }],
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
