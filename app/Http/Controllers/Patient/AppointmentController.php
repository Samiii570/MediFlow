<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user', 'doctor.department')
            ->latest('appointment_date')
            ->paginate(15);

        return view('patient.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('patient.appointments.create', compact('departments'));
    }

    public function getDoctors($departmentId)
    {
        $doctors = Doctor::where('department_id', $departmentId)
            ->with('user')
            ->get();

        return response()->json($doctors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
        ]);

        $patient = Auth::user()->patient;
        $doctorId = $validated['doctor_id'];
        $date = $validated['appointment_date'];

        // Generate token number
        $tokenNo = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', $date)
            ->count() + 1;

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorId,
            'appointment_date' => $date,
            'token_no' => $tokenNo,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', "Appointment booked successfully! Your token number is #{$tokenNo}.");
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor.user', 'doctor.department', 'prescription.medicines']);
        return view('patient.appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        $patient = Auth::user()->patient;
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }

        $appointment->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }
}
