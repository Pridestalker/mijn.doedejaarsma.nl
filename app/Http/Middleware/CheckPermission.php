<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class CheckPermission
 *
 * @category Middleware
 * @package  App\Http\Middleware
 * @author   Mitch Hijlkema <mitchhijlkema@hotmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     null
 */
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request      $request    The current request
     * @param Closure      $next       closure where to go to next
     * @param String|array $permission the permission to check
     * @param null         $entity
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $entity = null)
    {
        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);
        
        
        foreach ($permissions as $p) {
            if (!app('auth')->user()->can($p, $entity)) {
                abort(403);
            }
        }
    
        return $next($request);
    }
}
