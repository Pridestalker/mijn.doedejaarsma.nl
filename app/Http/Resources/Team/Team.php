<?php

namespace App\Http\Resources\Team;

use App\Http\Resources\User\UserCollection;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class Team extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $products = [];
        
        foreach ($this->users()->pluck('id') as $id) {
            $products = Product::whereUserId($id)->pluck('name', 'id');
        }
        
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
            'members'   => $this->users()->pluck('name', 'id'),
            'products'  => $products
        ];
    }
}
