<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;
        $prescriptions = Prescription::whereHas('appointment', function ($q) use ($doctor) {
            $q->where('doctor_id', $doctor->id);
        })->with(['appointment.patient.user', 'medicines'])
          ->latest()
          ->paginate(15);

        return view('doctor.prescriptions.index', compact('prescriptions'));
    }

    public function create(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user', 'doctor.department']);
        $medicines = Medicine::orderBy('medicine_name')->get();
        return view('doctor.prescriptions.create', compact('appointment', 'medicines'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'nullable|string',
            'medicines.*.duration' => 'nullable|string',
            'medicines.*.frequency' => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'appointment_id' => $appointment->id,
            'diagnosis' => $validated['diagnosis'],
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($validated['medicines'] as $med) {
            PrescriptionMedicine::create([
                'prescription_id' => $prescription->id,
                'medicine_id' => $med['medicine_id'],
                'dosage' => $med['dosage'] ?? null,
                'duration' => $med['duration'] ?? null,
                'frequency' => $med['frequency'] ?? null,
            ]);
        }

        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.prescriptions.show', $prescription)
            ->with('success', 'Prescription created successfully.');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['appointment.patient.user', 'appointment.doctor.user', 'appointment.doctor.department', 'medicines']);
        return view('doctor.prescriptions.show', compact('prescription'));
    }

    public function downloadPdf(Prescription $prescription)
    {
        $prescription->load(['appointment.patient.user', 'appointment.doctor.user', 'appointment.doctor.department', 'medicines']);

        $pdf = Pdf::loadView('pdf.prescription', compact('prescription'));
        $pdf->setPaper('a4');

        return $pdf->download('prescription-' . $prescription->id . '.pdf');
    }
}
