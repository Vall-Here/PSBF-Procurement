<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            Alert::info('Not Auth', 'Redirect to login');
            return redirect('login');
        }

        if (!$request->user()->hasRole($role,'web')) {
            return redirect('index');
        }

        return $next($request);
    }
}
