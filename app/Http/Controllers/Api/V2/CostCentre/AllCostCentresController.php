<?php

namespace App\Http\Controllers\Api\V2\CostCentre;

use App\Models\CostCentre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\is_admin;

class AllCostCentresController extends Controller
{
    public function __invoke(Request $request)
    {
        if (is_admin()) {
            return JsonResource::make(CostCentre::all());
        }

        return JsonResource::make(\Auth::user()->teams()->firstOrFail()->cost_centres);
    }
}
