<?php
namespace TrainingTracker\Http\Middleware;

use Closure;

class CheckMoodleAuthentication
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
            if ($request->expectsJson()) {
                throw new \Exception("You are not authenticated.");
            }

            abort(401, "You are not authenticated on Moodle.");
        }

        return $next($request);
    }
}