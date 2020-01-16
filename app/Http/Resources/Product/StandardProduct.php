<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class StandardProduct
 * @package App\Http\Resources\Product
 *
 * @mixin \App\Models\StandardProduct
 */
class StandardProduct extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
	        'description'   => $this->info->description,
            'soort'         => $this->info->type,
            'format'        => $this->info->format,
            'attachment'    => $this->info->attachment,
            'options'       => $this->info->options,
			'team'			=> $this->team_id
        ];
    }
}
