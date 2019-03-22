<?php

namespace App\Http\Controllers\Api\V1\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        
        if (!$user->notifications()->exists()) {
            return response()
                ->json(
                    [
                        'message'       => 'Geen notificaties gevonden.'
                    ],
                    204
                );
        }
     
        return response()
            ->json($user->notifications->toArray());
    }
    
    public function unread()
    {
        $user = \Auth::user();
        
        if (!$user->unreadNotifications()->exists()) {
            return response()
                ->json(
                    [
                        'message'       => 'Geen notificaties gevonden.'
                    ],
                    204
                );
        }
        
        return response()
            ->json($user->unreadNotifications->toArray());
    }
    
    public function read()
    {
        $user = \Auth::user();
        
        if (!$user->readNotifications()->exists()) {
            return response()
                ->json(
                    [
                        'message'       => 'Geen notificaties gevonden.'
                    ],
                    204
                );
        }
        
        return response()
            ->json($user->readNotifications->toArray());
    }
    
    public function delete($id)
    {
        try {
            \Auth::user()->notifications()->findOrFail($id)->delete();
        } catch (\Exception $e) {
            return response()
                ->json($e->getMessage(), 500);
        }
        
        return response([], 204);
    }
}
