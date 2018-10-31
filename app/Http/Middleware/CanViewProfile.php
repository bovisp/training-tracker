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

        foreach(moodleauth()->user()->reportingStructure() as $employee) {
            if ($employee['id'] === $this->userIdFromRequest() && $employee['rank'] > moodleauth()->user()->roles->first()->rank && moodleauth()->user()->active === 1) {
                return $next($request);
            }
        }

        return abort(401, "You are not allowed to view this.");
    }

    protected function userIdFromRequest()
    {
        return (int) explode("/", request()->url())[4];
    }

    protected function authenticatedUsersProfile() {
        return (moodleauth()->id() === $this->userIdFromRequest()) && moodleauth()->user()->active === 1;
    }
}