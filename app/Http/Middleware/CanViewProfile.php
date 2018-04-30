<?php

namespace TrainingTracker\Http\Middleware;

use Closure;

class CanViewProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! moodleauth()->check()) {
            abort(404);
        }

        if (moodleauth()->admin()) {
            return $next($request);
        }

        if (moodleauth()->user()->hasRole('administrator')) {
            return $next($request);
        }

        if ($this->authenticatedUsersProfile()) {
            return $next($request);
        }

        return abort(404);
    }

    protected function userIdFromRequest()
    {
        return (int) array_values(array_slice(explode("/", request()->url()), -1))[0];
    }

    protected function authenticatedUsersProfile() {
        return (moodleauth()->id() === $this->userIdFromRequest()) && moodleauth()->user()->active === 1;
    }
}