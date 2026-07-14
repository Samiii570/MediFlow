<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\PharmacySale;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = PharmacySale::whereDate('sale_date', today())->sum('total_amount');
        $todaySalesCount = PharmacySale::whereDate('sale_date', today())->count();
        $totalMedicines = Medicine::count();
        $lowStockMedicines = Medicine::where('stock', '<=', 10)->count();
        $expiringMedicines = Medicine::where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->where('expiry_date', '>=', today())
            ->count();
        $expiredMedicines = Medicine::where('expiry_date', '<', today())->count();

        $recentSales = PharmacySale::with(['patient.user', 'saleItems.medicine'])
            ->latest()
            ->limit(10)
            ->get();

        $expiringMedicineList = Medicine::where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->orderBy('expiry_date')
            ->get();

        // Weekly sales data
        $weeklySales = PharmacySale::where('sale_date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('sale_date, sum(total_amount) as total, count(*) as count')
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        return view('pharmacist.dashboard', compact(
            'todaySales', 'todaySalesCount', 'totalMedicines',
            'lowStockMedicines', 'expiringMedicines', 'expiredMedicines',
            'recentSales', 'expiringMedicineList', 'weeklySales'
        ));
    }
}
