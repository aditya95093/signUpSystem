<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 
class RestrictAfterDashboard
{
    public function handle(Request $request, Closure $next)
    {
        $restrictedRoutes = ['login', 'registration', 'register', 'loginUser'];

        if (Auth::check() && session('visited_dashboard', false) && in_array($request->route()->getName(), $restrictedRoutes)) {
            return redirect()->route('dashboard')->with('error', 'You cannot navigate to login or registration pages without logging out.');
        }

        if ($request->route()->getName() == 'dashboard') {
            session(['visited_dashboard' => true]);
        }

        return $next($request);
    }
}
