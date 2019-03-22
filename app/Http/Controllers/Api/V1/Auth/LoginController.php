<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
            return;
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $token = User::where(
            $this->username(),
            $this->credentials($request)[$this->username()]
        )->first()
        ->createToken(
            $request->has('token_name') ?
                $request->get('token_name') :
                'Personal Access token'
         );
        
        $this->clearLoginAttempts($request);

        return response()
            ->json([
                'access_token'  => $token->accessToken,
                'type'          => 'Bearer ',
            ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response()
            ->json(
                [
                    'message'   => 'Unauthorized'
                ],
                403
            );
    }

    protected function attemptLogin(Request $request)
    {
        return $this->checkCredentials(
            $this->credentials($request)
        );
    }

    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username()   => 'required|string',
                'password'          => 'required|string',
            ]
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function username()
    {
        return 'email';
    }
    
    protected function checkCredentials($credentials)
    {
        if (!isset($credentials[$this->username()])) {
            return false;
        }
        
        if (!isset($credentials['password'])) {
            return false;
        }
        
        $pass = User::where(
            $this->username(),
            $credentials[$this->username()]
        )
            ->pluck('password')
            ->first();
        
        return \Hash::check($credentials['password'], $pass);
    }
}
