<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('medicine_name', 'like', "%{$search}%");
        }

        if ($request->has('status') && $request->status === 'low_stock') {
            $query->where('stock', '<=', 10);
        } elseif ($request->has('status') && $request->status === 'expiring') {
            $query->where('expiry_date', '<=', now()->addDays(30));
        } elseif ($request->has('status') && $request->status === 'expired') {
            $query->where('expiry_date', '<', now());
        }

        $medicines = $query->orderBy('medicine_name')->paginate(15);

        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
        ]);

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine added successfully.');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'medicine_name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'required|date',
        ]);

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'Medicine updated successfully.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'Medicine deleted successfully.');
    }
}
