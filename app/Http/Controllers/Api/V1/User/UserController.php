<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Resources\User\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return User
     */
    public function whoami(Request $request)
    {
        return new User( Auth::user());
    }
}
