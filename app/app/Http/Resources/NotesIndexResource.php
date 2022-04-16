<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Date\Date;

class NotesIndexResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'notes_name' => $this->notes_name,
            'content' => $this->content,
            'creator' => $this->user_sender_id == $this->user_receiver_id? true : false,
            'created_at' => Date::parse($this->created_at)->format('j F Y'),
        ];
    }
}
