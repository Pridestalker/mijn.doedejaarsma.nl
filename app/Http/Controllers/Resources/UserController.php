<?php

namespace App\Http\Controllers\Resources;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::active()->get();

        return \View::make('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->to('register');
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
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        //
        return \View::make('users.show')
            ->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        //
        return \View::make('users.edit')
            ->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        //
        if (\Auth::user() !== $user && !\Auth::user()->isAn('admin')) {
            return back()
                ->with(
                    'status',
                    'Je hebt geen toestemming om andere accounts aan te passen'
                );
        }

        $user->update($request->all());

        return back()
            ->with('status', "$user->name aangepast!");
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
}
