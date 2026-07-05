<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'doctor' => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patient.dashboard'),
            'pharmacist' => redirect()->route('pharmacist.dashboard'),
            'receptionist' => redirect()->route('receptionist.dashboard'),
            default => view('dashboard'),
        };
    }
}
