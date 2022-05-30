<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
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
            'files_name' => $this->files_name,
            'path' =>  Storage::url($this->path),
            'size' => $this->size,  // 'size'=>intval($this->size /1024 /1024) ,
                'description' => $this->description,
            'creator' => $this->user_sender_id == $this->user_receiver_id ? true : false,
            'created_at' => $this->created_at,
        ];
    }
}
