<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Date\Date;

class AccountIndexResource extends JsonResource
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
            'id' => $this->id,
            'account_name' => $this->account_name,
            'login' => $this->login,
            'password' => $this->password,
            'description'=>$this->description,
            'creator' => $this->user_sender_id == $this->user_receiver_id ? true : false,
            'created_at' => $this->created_at,
        ];
    }
}
