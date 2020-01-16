<?php

namespace App\Http\Controllers\Api\V2\Team;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateTeamController extends Controller
{
    public function __invoke(Request $request, Team $team)
    {
        $team->update($request->all());

        $team->save();
        return \App\Http\Resources\Team\Team::make($team);
    }
}
