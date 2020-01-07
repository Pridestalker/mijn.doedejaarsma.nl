<?php

namespace App\Http\Controllers\Api\V2\CostCentre;

use App\Models\CostCentre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateCostCentreController extends Controller
{
    public function __invoke(Request $request)
    {
        $cc = CostCentre::create($request->all());

        return JsonResource::make($cc);
    }
}
