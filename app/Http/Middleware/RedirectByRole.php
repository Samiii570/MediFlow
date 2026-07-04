<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->routeIs('dashboard')) {
            $user = Auth::user();
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'doctor' => redirect()->route('doctor.dashboard'),
                'patient' => redirect()->route('patient.dashboard'),
                'pharmacist' => redirect()->route('pharmacist.dashboard'),
                'receptionist' => redirect()->route('receptionist.dashboard'),
                default => $next($request),
            };
        }

        return $next($request);
    }
}
