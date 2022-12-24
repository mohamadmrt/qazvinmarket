<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\CalendarUtils;

class CommentCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
                return [
                    'id'=>$this->id,
                    'username' => $this->name,
                    'comment' => $this->text,
                    'admin_reply' => $this->admin_reply,
                    'date' => gregorian2jalali_without_seconds($this->created_at),
        ];
    }
}
