<?php

namespace App\Http\Controllers\Api\V2\CostCentre;

use App\Models\CostCentre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function App\is_admin;

class AllCostCentresController extends Controller
{
    public function __invoke(Request $request)
    {
        if (is_admin()) {
            return CostCentre::all();
        }

        return \Auth::user()->teams()->firstOrFail()->cost_centres;
    }
}
