<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Medicine;
use App\Models\PharmacySale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        $totalDoctors = Doctor::count();
        $totalRevenue = PharmacySale::whereDate('sale_date', today())->sum('total_amount');
        $lowStockMedicines = Medicine::where('stock', '<=', 10)->count();

        // Appointments per day (last 7 days)
        $appointmentsPerDay = Appointment::where('appointment_date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('appointment_date, count(*) as count')
            ->groupBy('appointment_date')
            ->orderBy('appointment_date')
            ->get();

        // Revenue per day (last 7 days)
        $revenuePerDay = PharmacySale::where('sale_date', '>=', Carbon::now()->subDays(7))
            ->selectRaw('sale_date, sum(total_amount) as total')
            ->groupBy('sale_date')
            ->orderBy('sale_date')
            ->get();

        // Department-wise patient load
        $departmentLoad = Department::withCount(['doctors' => function ($q) {
            $q->withCount('appointments');
        }])->get();

        // Medicine stock levels (top 10)
        $medicineStock = Medicine::orderBy('stock', 'asc')->limit(10)->get();

        // Recent appointments
        $recentAppointments = Appointment::with(['patient.user', 'doctor.user', 'doctor.department'])
            ->latest()
            ->limit(10)
            ->get();

        // Expiring medicines
        $expiringMedicines = Medicine::where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->orderBy('expiry_date')
            ->get();

        return view('admin.dashboard', compact(
            'totalPatients', 'todayAppointments', 'totalDoctors', 'totalRevenue',
            'lowStockMedicines', 'appointmentsPerDay', 'revenuePerDay',
            'departmentLoad', 'medicineStock', 'recentAppointments', 'expiringMedicines'
        ));
    }
}
