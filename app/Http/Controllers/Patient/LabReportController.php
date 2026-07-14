<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\LabTest;
use Illuminate\Support\Facades\Auth;

class LabReportController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;
        $labTests = LabTest::where('patient_id', $patient->id)
            ->with('doctor.user', 'labReport')
            ->latest()
            ->paginate(15);

        return view('patient.lab-reports.index', compact('labTests'));
    }
}
