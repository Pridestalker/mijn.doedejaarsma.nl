<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Teams\RegisterTeamController;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $teams = Team::all();
        
        return \View::make('teams.index')
                    ->with('teams', $teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        if (!$this->isUserAdmin() && !$this->isUserCustomer()) {
            return redirect('home')
                ->with('status', 'je bent niet bevoegd om deze pagina te bekijken');
        }
        return \View::make('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate(
            [
            'name'  => 'required|unique:teams',
            'email' => 'required|email',
            ]
        );
        
        try {
            Team::create($request->only('name', 'email'));
        } catch (\Exception $e) {
        	\Log::error($e->getMessage(), $e->getTrace());
            return back()->with('status', $e->getMessage());
        }
        
        return back()->with('status', 'Bedrijf toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  Team $team
     * @return Response
     */
    public function show(Team $team)
    {
        //
        return \View::make('teams.show')
            ->with('team', $team);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit(Team $team)
    {
        //
        return \View::make('teams.edit')
            ->with('team', $team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    protected function isUserAdmin()
    {
        return \Auth::user()->isAn('admin');
    }
    
    protected function isUserDesigner()
    {
        return \Auth::user()->isA('designer');
    }
    
    protected function isUserCustomer()
    {
        return \Auth::user()->isA('customer');
    }
}
