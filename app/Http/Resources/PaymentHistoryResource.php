<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
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
            'user' => [
                'id' => $this->user_id,
                'full_name' => $this->user->full_name
            ],
            'amount' => $this->amount,
            'addBy' => $this->addByUser->full_name,
            'date' => date('Y-m-d H:i:s',strtotime($this->created_at))
        ];
    }
}
