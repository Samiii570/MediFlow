<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Department;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::orderBy('name')->get();
        $doctors = Doctor::with('user', 'department')->get();
        return view('queue.index', compact('departments', 'doctors'));
    }

    public function getQueue(Request $request)
    {
        $doctorId = $request->doctor_id;
        $date = $request->date ?? today()->toDateString();

        $query = Appointment::whereDate('appointment_date', $date)
            ->with('patient.user', 'doctor.user', 'doctor.department');

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        $appointments = $query->orderBy('token_no')->get();

        $currentToken = $appointments->where('status', 'in_progress')->first();
        $pendingTokens = $appointments->where('status', 'pending')->values();
        $completedCount = $appointments->where('status', 'completed')->count();

        // Transform for JSON
        $transform = fn($a) => [
            'id' => $a->id,
            'token_no' => $a->token_no,
            'status' => $a->status,
            'patient_name' => $a->patient->user->name ?? 'Unknown',
            'doctor_name' => $a->doctor->user->name ?? 'Unknown',
            'department_name' => $a->doctor->department->name ?? '',
        ];

        return response()->json([
            'current' => $currentToken ? $transform($currentToken) : null,
            'pending' => $pendingTokens->map($transform)->values(),
            'completed_count' => $completedCount,
            'total' => $appointments->count(),
        ]);
    }
}
