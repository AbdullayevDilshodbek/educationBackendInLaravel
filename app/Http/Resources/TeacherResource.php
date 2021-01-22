<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->user->full_name,
            'user' => [
                'id' => $this->user->id,
            ],
            'subject' => [
                'id' => $this->subject->id,
                'subject_name' => $this->subject->subject_name
            ]
        ];
    }
}
