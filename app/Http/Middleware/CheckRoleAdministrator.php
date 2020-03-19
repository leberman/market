<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleAdministrator
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
        if (! $request->user()->hasRole('administrator')) {
            return response()->json([
                'message' => 'شما دسترسی لازم برای این قسمت را ندارید.',
            ]);
        }
        return $next($request);
    }
}
