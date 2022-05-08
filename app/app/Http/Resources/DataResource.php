<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
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
            'id' => $this->notes_id ?? $this->account_id ?? $this->files_id,
            'creator' => $this->user_sender_id == $this->user_receiver_id ? true : false,
            'name' => $this->notes_name ?? $this->account_name ?? $this->files_name,
            'created_at' => $this->created_at,
            'type_table' => $this->notes_id != null ? 0 : ($this->account_id != null ? 2 : ($this->files_id != null ? 1 : null))
        ];
    }
}
