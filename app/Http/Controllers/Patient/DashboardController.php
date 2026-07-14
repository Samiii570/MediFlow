<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\LabTest;
use App\Models\PharmacySale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->with('doctor.user', 'doctor.department')
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        $recentPrescriptions = Prescription::whereHas('appointment', function ($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->with(['appointment.doctor.user', 'medicines'])
          ->latest()
          ->limit(5)
          ->get();

        $recentLabTests = LabTest::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest()
            ->limit(5)
            ->get();

        $upcomingFollowUps = Appointment::where('patient_id', $patient->id)
            ->where('follow_up_date', '>=', today())
            ->whereNotNull('follow_up_date')
            ->with('doctor.user')
            ->orderBy('follow_up_date')
            ->limit(5)
            ->get();

        $totalAppointments = Appointment::where('patient_id', $patient->id)->count();
        $totalPrescriptions = Prescription::whereHas('appointment', function ($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->count();

        return view('patient.dashboard', compact(
            'patient', 'upcomingAppointments', 'recentPrescriptions',
            'recentLabTests', 'upcomingFollowUps', 'totalAppointments',
            'totalPrescriptions'
        ));
    }
}
