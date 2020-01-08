<?php

namespace App\Http\Controllers\Api\V2\Team;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteTeamController extends Controller
{
    public function __invoke(Request $request, Team $team)
    {
        try {
            $team->delete();
        } catch (\Exception $exception) {
            throw $exception;
        }

        return response([], 204);
    }
}
