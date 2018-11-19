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
                throw new \Exception(trans('app.errors.general.notauthenticated'));
            }

            abort(401, trans('app.errors.general.notauthenticated'));
        }

        return $next($request);
    }
}