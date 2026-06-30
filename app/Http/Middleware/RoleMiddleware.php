<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            // If admin tries to access user page, redirect to admin dashboard
            if (auth()->user()->role === 'admin' && $role === 'user') {
                return redirect()->route('admin.dashboard');
            }
            // If user tries to access admin page, redirect to customer home
            if (auth()->user()->role === 'user' && $role === 'admin') {
                return redirect()->route('home');
            }
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
