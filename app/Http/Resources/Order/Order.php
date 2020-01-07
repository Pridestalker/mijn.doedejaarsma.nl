<?php

namespace App\Http\Resources\Order;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Order
 *
 * @mixin \App\Models\Order
 *
 * @package App\Http\Resources\Order
 */
class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->orderable instanceof Product) {
            return $this->productToArray($request);
        }

        return parent::toArray($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function productToArray($request)
    {
        return (new \App\Http\Resources\Product\Product($this->orderable))
            ->toArray($request);
    }
}
