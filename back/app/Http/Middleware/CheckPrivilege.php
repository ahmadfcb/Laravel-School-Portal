<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckPrivilege
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $user
     * @param array $privilege
     * @return mixed
     */
    public function handle( $request, Closure $next, ...$privilege )
    {
        if ( User::hasPrivilege( auth()->user(), $privilege ) === false ) {
            abort( 401, "You are not authorized to access this page." );
        }

        return $next( $request );
    }
}
