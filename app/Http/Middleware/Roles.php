<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /*public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }*/

    public function handle(Request $request, Closure $next, $role)
    {
        //Comprobamos si el campo correspondiente (usuarios o noticicas) es igual a 1
        if (Auth::user()->$role != 1) {
            return redirect('admin')->with('warning', 'Operación no autorizada');
        }

        return $next($request);
    }

}
