<?php

namespace App\Http\Controllers\Api\V1\User;

use Auth;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class NotificationsController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(
                [
                    'error' => 'Unauthenticated'
                ],
                403
            );
        }
        
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
    
    /**
     * @return JsonResponse
     */
    public function unread(): JsonResponse
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(
                [
                    'error' => 'Unauthenticated'
                ],
                403
            );
        }
        
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
    
    /**
     * @return JsonResponse
     */
    public function read(): JsonResponse
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(
                [
                    'error' => 'Unauthenticated'
                ],
                403
            );
        }
        
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
    
    /**
     * @param $id
     *
     * @return ResponseFactory|JsonResponse|Response
     */
    public function delete($id)
    {
        try {
            Auth::user()
                ->notifications()
                ->findOrFail($id)
                ->delete();
        } catch (Exception $e) {
            return response()
                ->json($e->getMessage(), 500);
        }
        
        return response([], 204);
    }
}
