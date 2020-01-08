<?php

namespace App\Http\Controllers\Api\V2\StandardProduct;

use App\Http\Controllers\Services\StandardProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateStdProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $service = StandardProductService::make($request);

        try {
            $product = $service->store();
        } catch (\Exception $e) {
            return response()
                ->json([
                    'error' => $e->getMessage()
                ], 500);
        }

        return response()
            ->json(new JsonResource($product));
    }
}
