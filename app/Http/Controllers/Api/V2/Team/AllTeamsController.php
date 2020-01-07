<?php

namespace App\Http\Controllers\Api\V2\Team;

use App\Http\Resources\Team\Team;
use App\Http\Controllers\Controller;

class AllTeamsController extends Controller
{
    public function __invoke()
    {
        return Team::collection(\App\Models\Team::all());
    }
}
