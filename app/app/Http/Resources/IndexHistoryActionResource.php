<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Jenssegers\Date\Date;

class IndexHistoryActionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'user_login' => $this->user->login,
            'type_action' => $this->action->action_name,
            'action_date'=> Date::parse($this->action_date)->format('j F Y')
        ];
    }
}
