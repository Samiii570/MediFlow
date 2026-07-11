<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;
        $query = Appointment::where('doctor_id', $doctor->id)->with('patient.user');

        if ($request->has('date') && $request->date) {
            $query->whereDate('appointment_date', $request->date);
        } else {
            $query->whereDate('appointment_date', today());
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('token_no')->paginate(20);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function updateStatus(Appointment $appointment, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $appointment->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $appointment->status]);
        }

        return redirect()->back()->with('success', 'Appointment status updated.');
    }

    public function labTests()
    {
        $doctor = Auth::user()->doctor;
        $labTests = LabTest::where('doctor_id', $doctor->id)
            ->with('patient.user')
            ->latest()
            ->paginate(15);

        $patients = Patient::with('user')->get();

        return view('doctor.lab-tests.index', compact('labTests', 'patients'));
    }

    public function orderLabTest(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_name' => 'required|string|max:255',
        ]);

        $doctor = Auth::user()->doctor;

        LabTest::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctor->id,
            'test_name' => $validated['test_name'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Lab test ordered successfully.');
    }
}
