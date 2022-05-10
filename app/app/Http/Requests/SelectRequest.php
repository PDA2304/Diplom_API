<?php

namespace App\Http\Requests;

class SelectRequest extends ApiRequest
{

    public function rules()
    {
        return [
            '*' =>'required|array',
            '*.id' => 'required|integer',
            '*.type_table' => 'required|integer',
        ];
    }
}
