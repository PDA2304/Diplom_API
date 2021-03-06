<?php

namespace App\Http\Requests;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class FilesUpdateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'id' => ['required'],
            'file_name' => ['required', 'max:30', function ($attribute, $value, $fail) {
                if (File::where('user_id', '=', $this->user_id)->where('files_name', '=', $value)->where('id', '!=', $this->id)->first()) {
                    $fail('Файл с таким названием уже существует');
                }
            }],
            'description' => ['max:255'],
            'size' => ['required', 'integer'],
            'file' => ['required', 'max:5000', 'mimes:jpeg,png,pdf,gif,svg,xlsx,docx,doc'],
        ];
    }

    public function attributes()
    {
        return [
            "file_name" => 'название файла',
            "file" => 'файл',
        ];
    }
}
