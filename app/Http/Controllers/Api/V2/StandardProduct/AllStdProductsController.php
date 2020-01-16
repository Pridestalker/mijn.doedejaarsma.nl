<?php

namespace App\Http\Controllers\Api\V2\StandardProduct;

use App\Models\StandardProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use Illuminate\Http\Resources\Json\JsonResource;
use function App\is_admin;

class AllStdProductsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResource
     */
    public function __invoke(Request $request)
    {
        if (is_admin()) {
            return JsonResource::collection(StandardProduct::all());
        }

        try {
            $team_id = \Auth::user()->teams()->firstOrFail()->id;
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        }

        return JsonResource::collection(StandardProduct::where('team_id', '=', $team_id)->get());
    }
}
