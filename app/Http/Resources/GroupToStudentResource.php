<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupToStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student' => [
                'id' => $this->student->id,
                'full_name' => $this->student->first_name.' '.$this->student->last_name.' '.$this->student->middle_name,
            ],
            'group' => [
                'id' => $this->group->id,
                'group_name' => $this->group->group_name,
            ],
            'credit' => $this->credit,
            'discount' => $this->discount,
            'status' => $this->status,
            'add_date' => $this->change_group_date == null ? date('Y-m-d',strtotime($this->created_at))
                : date('Y-m-d',strtotime($this->change_group_date))
        ];
    }
}
