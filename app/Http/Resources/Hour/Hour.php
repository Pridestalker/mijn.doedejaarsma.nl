<?php

namespace App\Http\Resources\Hour;

use Illuminate\Http\Resources\Json\JsonResource;

class Hour extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'product'   => [
                'id'        => $this->product_id,
                'data'      => $this->product
            ],
            'user'      => [
                'id'        => $this->user_id,
                'data'      => $this->user,
            ],
            'hours'     => $this->hours,
            'created_at'=> $this->created_at
        ];
    }
}
