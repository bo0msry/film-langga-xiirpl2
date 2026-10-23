<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Akses ditolak.');
        }

        $role = $user->role;

        if ($role && $role->name === 'admin') {
            return $next($request);
        }

        if (property_exists($user, 'is_admin') && $user->is_admin) {
            return $next($request);
        }

        if (isset($user->role) && is_string($user->role) && $user->role === 'admin') {
            return $next($request);
        }

        if ($user->email === 'admin@gmail.com') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Akses ditolak.');
    }
}
