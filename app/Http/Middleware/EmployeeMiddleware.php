<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if employee is logged in using "employee" guard
        if (Auth::guard('employee')->check()) {
            return $next($request);
        }

        // If not authenticated, redirect to employee login page
        return redirect()->route('employee.login')->with('error', 'Please login as employee to access this page.');
    }
}
