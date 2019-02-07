<?php

namespace App\Http\Controllers\Teams;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// TODO: Move to \App\Http\Resources\TeamController::class
class RegisterTeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showCreationForm()
    {
        return \View::make('teams.create');
    }
    
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            ''
        ]);
    }
    
    protected function create(array $data)
    {
        return Team::create([
        
        ]);
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $team = $this->create($request->all());
    }
}
