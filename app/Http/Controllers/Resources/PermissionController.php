<?php

namespace App\Http\Controllers\Resources;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        return view('Permissions.index')
            ->with('permissions', \Silber\Bouncer\Database\Ability::all());
    }
    
    public function create()
    {
        return view('Permissions.create');
    }
    
    public function store(Request $request)
    {
        $permission = \Bouncer::ability()->firstOrCreate($request->except('_token'));
        
        return back()
        ->with('status', "$permission->name aangemaakt.");
    }
    
    public function patchUser(Request $request, User $user)
    {
        $permissions = array_keys($request->except('_token'));
        
        \Bouncer::sync($user)->abilities($permissions);
        return back();
    }
}
