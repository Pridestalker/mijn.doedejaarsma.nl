<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Hour\ProductHour;
use App\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Product
 * @package App\Http\Resources\Product
 *
 * @mixin \App\Models\Product
 */
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
            'description'       => $this->getDescription(),
            'options'           => $this->getOptions(),
            'format'            => $this->getFormat(),
            'attachment'        => $this->getAttachment(),
            'factuur'           => $this->getFactuur(),
            'kostenplaats'      => $this->getCostsCentre(),
            'referentie'        => $this->getReference(),

            'owner'             => $this->getOwner(),

            'soort'             => $this->getInfo('type'),
            'status'            => $this->order->status,

            'deadline'          => $this->order->deadline,

            'created_at'        => $this->order->created_at,
            'updated_at'        => $this->order->updated_at,
            'updated_by'        => self::when(isset($this->order->updated_by), \App\User::find($this->order->updated_by)),

            'hours'             => [
                'count'             => count($this->hours),
                'total'             => $this->hours->sum('hours'),
                'data'              => ProductHour::collection($this->hours),
            ],

            'links'             => $this->links()
        ];
    }

    protected function getDescription()
    {
        return self::when($this->getInfo('description'), $this->getInfo('description'));
    }

    protected function getOptions()
    {
        return self::when($this->getInfo('options'), $this->getInfo('options'));
    }

    protected function getFormat()
    {
        return self::when($this->getInfo('format'), $this->getInfo('format'));
    }

    protected function getAttachment()
    {
        return self::when($this->getInfo('attachment'), $this->getInfo('attachment'));
    }

    protected function getFactuur()
    {
        return self::when($this->getInfo('factuur'), $this->getInfo('factuur'));
    }

    protected function getCostsCentre()
    {
        return self::when($this->getInfo('cost_centre'), $this->getInfo('cost_centre'));
    }

    protected function getReference()
    {
        return self::when($this->getInfo('reference'), $this->getInfo('reference'));
    }

    protected function getOwner()
    {
        return new User(\App\User::find($this->order->user_id));
    }

    protected function getInfo($field)
    {
        try {
            return $this->info->$field;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function links(): array
    {
        return [
            'self'  => [
                'web'       => route('products.show', $this->id),
                'api'       => route('api.products.show', $this->id),
            ],
            'overview'  =>  [
                'web'       => route('products.index'),
                'api'       => route('products.index')
            ],
            'owner'     =>  [
                'web'       => route('users.show', $this->order->user_id)
            ]
        ];
    }
}
