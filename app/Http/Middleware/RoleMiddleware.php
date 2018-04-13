<?php

namespace TrainingTracker\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if (!moodleauth()->user()->hasRole($role)) {
            abort(404);
        }

         if ($permission !== null && !moodleauth()->user()->can($permission)) {
            abort(404);
        }        
        
        return $next($request);
    }
}
