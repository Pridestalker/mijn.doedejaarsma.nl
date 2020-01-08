<?php

namespace App\Http\Controllers\Api\V2\StandardProduct;

use App\Models\StandardProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use function App\is_admin;

class AllStdProductsController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request)
    {
        if (is_admin()) {
            return AnonymousResourceCollection::collection(StandardProduct::all());
        }

        try {
            $team_id = \Auth::user()->team()->firstOrFail()->id;
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        }

        return AnonymousResourceCollection::collection(StandardProduct::where('team_id', '=', $team_id)->get());
    }
}
