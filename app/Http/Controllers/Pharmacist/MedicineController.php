<?php

namespace App\Http\Controllers\Pharmacist;

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

        return view('pharmacist.medicines.index', compact('medicines'));
    }

    public function updateStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $medicine->update($validated);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'stock' => $medicine->stock]);
        }

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }
}
