<?php

namespace TrainingTracker\Http\Middleware;

use Closure;
use TrainingTracker\Domains\Permissions\Permission;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $permission = Permission::where('type', $permission)->get()->first();
        
        if (!moodleauth()->user()->hasPermissionTo($permission)) {
            abort(404);
        }
        
        return $next($request);
    }
}
