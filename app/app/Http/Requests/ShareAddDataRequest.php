<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareAddDataRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'data_id' => 'required|integer',
            'user_sender_id' => 'required|integer',
            'type_table' => 'required|integer',
            'user_receiver' => 'required|array',
            'user_receiver.*' => 'required|integer',
        ];
    }
}
