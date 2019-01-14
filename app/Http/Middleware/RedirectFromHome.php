<?php

namespace TrainingTracker\Http\Middleware;

use Closure;

class RedirectFromHome
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
        if (moodleauth()->user()->roles->first()->type === 'administrator') {
            return redirect('/users');
        }

        return redirect('/users/' . moodleauth()->id());
    }
}