<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PharmacySale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = PharmacySale::with(['patient.user', 'saleItems.medicine'])
            ->latest()
            ->paginate(15);

        return view('pharmacist.sales.index', compact('sales'));
    }

    public function create()
    {
        $medicines = Medicine::where('stock', '>', 0)->orderBy('medicine_name')->get();
        $patients = Patient::with('user')->get();
        return view('pharmacist.sales.create', compact('medicines', 'patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $pharmacist = Auth::user();
        $total = 0;

        $sale = PharmacySale::create([
            'patient_id' => $validated['patient_id'],
            'pharmacist_id' => $pharmacist->id,
            'sale_date' => now()->toDateString(),
            'total_amount' => 0,
        ]);

        foreach ($validated['items'] as $item) {
            $medicine = Medicine::findOrFail($item['medicine_id']);
            $qty = min($item['quantity'], $medicine->stock);
            $subtotal = $qty * $medicine->price;
            $total += $subtotal;

            SaleItem::create([
                'sale_id' => $sale->id,
                'medicine_id' => $medicine->id,
                'quantity' => $qty,
                'unit_price' => $medicine->price,
            ]);

            $medicine->decrement('stock', $qty);
        }

        $sale->update(['total_amount' => $total]);

        return redirect()->route('pharmacist.sales.show', $sale)
            ->with('success', 'Sale completed successfully! Total: $' . number_format($total, 2));
    }

    public function show(PharmacySale $sale)
    {
        $sale->load(['patient.user', 'pharmacist', 'saleItems.medicine']);
        return view('pharmacist.sales.show', compact('sale'));
    }

    public function downloadInvoice(PharmacySale $sale)
    {
        $sale->load(['patient.user', 'pharmacist', 'saleItems.medicine']);

        $pdf = Pdf::loadView('pdf.invoice', compact('sale'));
        $pdf->setPaper('a4');

        return $pdf->download('invoice-' . $sale->id . '.pdf');
    }
}
