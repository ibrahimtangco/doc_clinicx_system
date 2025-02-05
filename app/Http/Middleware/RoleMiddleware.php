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


    public function handle(Request $request, Closure $next, $roles): Response
    {
        $rolesArray = array_map('trim', explode('|', strtolower($roles)));

        $user = $request->user();

        if (!$user || !in_array(strtolower($user->userType), $rolesArray)) {
            return redirect()->back()->withErrors(['Unauthorized access']);
        }

        return $next($request);
    }
}
