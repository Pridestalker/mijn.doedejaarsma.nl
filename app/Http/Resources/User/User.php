<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Team\Team;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name'      => $this->name,
            'email'     => $this->email,
            'team'      => $this->bedrijf,
            'requests'  => $this->products,
            'role'      => $this->getRoles(),
            'permission'=> $this->getAbilities(),
            'projects'  => [
                'aangevraagd'   => [
                	'count'     => Product::requested()->count(),
	                'data'      => Product::requested()->get()
                ],
                'opgepakt'      => [
	                'count'     => Product::inProgress()->count(),
	                'data'      => Product::inProgress()->get()
                ],
                'afgerond'      => [
	                'count'     => Product::finished()->count(),
	                'data'      => Product::finished()->get()
                ],
            ]
        ];
    }
}
