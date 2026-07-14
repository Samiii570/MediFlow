<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\LabTest;
use App\Models\PharmacySale;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        $events = collect();

        // Registration event
        $events->push([
            'type' => 'registration',
            'title' => 'Registered as Patient',
            'description' => 'Patient account created',
            'date' => $patient->created_at,
            'icon' => 'user-plus',
        ]);

        // Appointments
        Appointment::where('patient_id', $patient->id)
            ->with('doctor.user', 'doctor.department')
            ->get()
            ->each(function ($appt) use ($events) {
                $events->push([
                    'type' => 'appointment',
                    'title' => "Appointment with {$appt->doctor->name}",
                    'description' => "{$appt->doctor->department->name} - {$appt->status}",
                    'date' => $appt->appointment_date,
                    'icon' => 'calendar',
                    'status' => $appt->status,
                ]);
            });

        // Prescriptions
        Prescription::whereHas('appointment', function ($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->with('appointment.doctor.user')->get()
          ->each(function ($rx) use ($events) {
              $events->push([
                  'type' => 'prescription',
                  'title' => 'Prescription issued',
                  'description' => "By {$rx->appointment->doctor->name} - " . $rx->medicines->count() . ' medicines',
                  'date' => $rx->created_at,
                  'icon' => 'document-text',
              ]);
          });

        // Lab Tests
        LabTest::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->get()
            ->each(function ($test) use ($events) {
                $events->push([
                    'type' => 'lab_test',
                    'title' => $test->test_name,
                    'description' => "Status: {$test->status}",
                    'date' => $test->created_at,
                    'icon' => 'beaker',
                    'status' => $test->status,
                ]);
            });

        // Pharmacy Sales
        PharmacySale::where('patient_id', $patient->id)
            ->get()
            ->each(function ($sale) use ($events) {
                $events->push([
                    'type' => 'pharmacy_sale',
                    'title' => 'Pharmacy Purchase',
                    'description' => 'Total: $' . number_format($sale->total_amount, 2),
                    'date' => $sale->sale_date,
                    'icon' => 'shopping-bag',
                ]);
            });

        $timeline = $events->sortBy('date')->values();

        return view('patient.timeline', compact('timeline'));
    }
}
