<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\LabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;
        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->with('patient.user')
            ->orderBy('token_no')
            ->get();

        $pendingCount = $todayAppointments->where('status', 'pending')->count();
        $completedCount = $todayAppointments->where('status', 'completed')->count();
        $totalToday = $todayAppointments->count();

        $upcomingFollowUps = Appointment::where('doctor_id', $doctor->id)
            ->where('follow_up_date', '>=', today())
            ->whereNotNull('follow_up_date')
            ->with('patient.user')
            ->orderBy('follow_up_date')
            ->limit(10)
            ->get();

        $pendingLabTests = LabTest::where('doctor_id', $doctor->id)
            ->where('status', 'pending')
            ->with('patient.user')
            ->latest()
            ->limit(10)
            ->get();

        // This week's appointment stats
        $weekStats = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', Carbon::now()->startOfWeek())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        return view('doctor.dashboard', compact(
            'doctor', 'todayAppointments', 'pendingCount', 'completedCount',
            'totalToday', 'upcomingFollowUps', 'pendingLabTests', 'weekStats'
        ));
    }
}
