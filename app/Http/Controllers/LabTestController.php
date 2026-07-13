<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use App\Models\LabReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabTestController extends Controller
{
    public function index()
    {
        $labTests = LabTest::with(['patient.user', 'doctor.user', 'labReport'])
            ->latest()
            ->paginate(15);

        return view('admin.lab-tests.index', compact('labTests'));
    }

    public function updateStatus(LabTest $labTest, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $labTest->update($validated);

        return redirect()->back()->with('success', 'Lab test status updated.');
    }

    public function uploadReport(Request $request, LabTest $labTest)
    {
        $validated = $request->validate([
            'report_file' => 'required|file|max:10240',
            'remarks' => 'nullable|string',
        ]);

        $file = $request->file('report_file');
        $filename = 'lab_report_' . $labTest->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/lab-reports'), $filename);

        LabReport::updateOrCreate(
            ['test_id' => $labTest->id],
            [
                'report_file' => $filename,
                'remarks' => $validated['remarks'] ?? null,
            ]
        );

        $labTest->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Lab report uploaded successfully.');
    }
}
