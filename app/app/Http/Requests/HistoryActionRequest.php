<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryActionRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required',
            'data_id' => 'required',
            'type_table_id' => 'required|integer'
        ];
    }
}
