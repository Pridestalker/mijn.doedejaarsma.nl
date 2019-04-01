<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->when(isset($this->description), $this->description),
            'options'           => $this->when(isset($this->options), $this->options),
            'format'            => $this->when(isset($this->format), $this->format),
            'attachment'        => $this->when(isset($this->attachment), $this->attachment),
            'factuur'           => $this->when(isset($this->factuur), $this->factuur),
            'kostenplaats'      => $this->when(isset($this->kostenplaats), $this->kostenplaats),
            'referentie'        => $this->when(isset($this->referentie), $this->referentie),
            
            'owner'             => new User(\App\User::find($this->user_id)),
            
            'soort'             => $this->soort,
            'status'            => $this->status,
            
            'deadline'          => $this->deadline,
            
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            
            'hours'             => [
                'count'             => count($this->hours),
                'total'             => $this->hours->sum('hours'),
                'data'              => $this->hours,
            ],
            
            'links'             => [
                'self'  => [
                    'web'       => route('products.show', $this->id),
                    'api'       => route('api.products.show', $this->id),
                ],
                'overview'  =>  [
                    'web'       => route('products.index'),
                    'api'       => route('products.index')
                ],
                'owner'     =>  [
                    'web'       => route('users.show', $this->user_id)
                ]
            ]
        ];
    }
}
