<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescriptionController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;
        $prescriptions = Prescription::whereHas('appointment', function ($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->with(['appointment.doctor.user', 'medicines'])
          ->latest()
          ->paginate(15);

        return view('patient.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['appointment.patient.user', 'appointment.doctor.user', 'appointment.doctor.department', 'medicines']);
        return view('patient.prescriptions.show', compact('prescription'));
    }

    public function downloadPdf(Prescription $prescription)
    {
        $prescription->load(['appointment.patient.user', 'appointment.doctor.user', 'appointment.doctor.department', 'medicines']);

        $pdf = Pdf::loadView('pdf.prescription', compact('prescription'));
        $pdf->setPaper('a4');

        return $pdf->download('prescription-' . $prescription->id . '.pdf');
    }
}
