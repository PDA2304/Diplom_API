<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataInformationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type_table_id' => ['required', 'integer'],
            'data_id' => ['required', 'integer'],
        ];
    }
}
