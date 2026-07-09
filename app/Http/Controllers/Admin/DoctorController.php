<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with(['user', 'department']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('department_id') && $request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        $doctors = $query->latest()->paginate(12);
        $departments = Department::orderBy('name')->get();

        return view('admin.doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'consultation_fee' => 'required|numeric|min:0',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'specialization' => $validated['specialization'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'consultation_fee' => $validated['consultation_fee'],
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'consultation_fee' => 'required|numeric|min:0',
        ]);

        $doctor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        $doctor->update([
            'department_id' => $validated['department_id'],
            'specialization' => $validated['specialization'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'consultation_fee' => $validated['consultation_fee'],
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
