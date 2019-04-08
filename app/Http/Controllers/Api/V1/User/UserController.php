<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Resources\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function whoami(Request $request)
    {
        return new User(\Auth::user());
    }
}
