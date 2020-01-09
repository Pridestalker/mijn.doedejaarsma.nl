<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('products.index');
    }

    public function removeNotification(\App\User $user, $notification)
    {
        $user->notifications->find($notification)->delete();

        return back();
    }

    public function customerApp()
	{
		return view('frontend.app');
	}
}
