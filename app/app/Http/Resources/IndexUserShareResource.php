<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexUserShareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_name' => User::find($this->shareData->user_receiver_id)->user_name,
            'user_login' => User::find($this->shareData->user_receiver_id)->user_name,
            'created_share'=>$this->created_at,
            'user_id' => $this->shareData->user_receiver_id
        ];
    }
}
