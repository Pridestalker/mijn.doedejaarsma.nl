<?php

namespace App\Http\Controllers\Api\V2\StandardProduct;

use App\Models\StandardProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReadStdProductController extends Controller
{
    public function __invoke(Request $request, StandardProduct $product)
    {
        return \App\Http\Resources\Product\StandardProduct::make($product);
    }
}
