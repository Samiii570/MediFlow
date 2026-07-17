<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Department;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayAppointments = Appointment::whereDate('appointment_date', today())
            ->with('patient.user', 'doctor.user', 'doctor.department')
            ->orderBy('token_no')
            ->get();

        $pendingCheckIns = $todayAppointments->where('status', 'pending');
        $totalPatients = Patient::count();

        $departments = Department::withCount('doctors')->get();

        return view('receptionist.dashboard', compact(
            'todayAppointments', 'pendingCheckIns', 'totalPatients', 'departments'
        ));
    }

    public function checkIn(Appointment $appointment)
    {
        if ($appointment->status === 'pending') {
            $appointment->update(['status' => 'in_progress']);
            return redirect()->back()->with('success', "Patient checked in. Token #{$appointment->token_no} is now in progress.");
        }

        return redirect()->back()->with('error', 'Cannot check in this appointment.');
    }
}
