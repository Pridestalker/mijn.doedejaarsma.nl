<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModifyPasswordController extends Controller
{
    public function patch(Request $request, User $user)
    {
        $this->validator($request->all())->validate();
        
        $user->password = \Hash::make($request->get('password'));
        $user->save();
        return back()->with('status', "$user->name, je wachtwoord is aangepast");
    }
    
    protected function validator(array $data)
    {
        return \Validator::make(
            $data,
            [
                'password'  => ['required', 'string', 'min:6', 'confirmed']
            ]
        );
    }
}
