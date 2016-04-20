<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // Check if the user is an admin
        if(!$request->user()->isAdmin()) {
            // Not an admin so redirect back
            return redirect()->back();
        }
        return $next($request);
    }
}
