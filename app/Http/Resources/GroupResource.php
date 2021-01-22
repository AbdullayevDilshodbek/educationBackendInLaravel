<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'group_name' => $this->group_name,
            'teacher' => [
                'id' => $this->teacher->id,
                'full_name' => $this->teacher->user->full_name,
                'status' => $this->teacher->user->status,
            ],
            'subject' => [
                'id' => $this->teacher->subject->id,
                'subject_name' => $this->teacher->subject->subject_name,
            ],
            'payment' => $this->payment,
            'teacher_part' => 100 * $this->teacher_part,
            'people_count' => $this->students->where('status',true)->count(),
            'status' => $this->status
        ];
    }
}
