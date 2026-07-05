<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboard;
use App\Http\Controllers\Doctor\PrescriptionController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointment;
use App\Http\Controllers\Patient\DashboardController as PatientDashboard;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointment;
use App\Http\Controllers\Patient\PrescriptionController as PatientPrescription;
use App\Http\Controllers\Patient\LabReportController;
use App\Http\Controllers\Patient\TimelineController;
use App\Http\Controllers\Pharmacist\DashboardController as PharmacistDashboard;
use App\Http\Controllers\Pharmacist\MedicineController as PharmacistMedicine;
use App\Http\Controllers\Pharmacist\SaleController;
use App\Http\Controllers\Receptionist\DashboardController as ReceptionistDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('departments', DepartmentController::class)->except(['show']);
    Route::resource('doctors', DoctorController::class)->except(['show']);
    Route::resource('medicines', MedicineController::class)->except(['show']);
    Route::get('/lab-tests', [LabTestController::class, 'index'])->name('lab-tests.index');
    Route::patch('/lab-tests/{labTest}/status', [LabTestController::class, 'updateStatus'])->name('lab-tests.status');
    Route::post('/lab-tests/{labTest}/report', [LabTestController::class, 'uploadReport'])->name('lab-tests.report');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboard::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DoctorAppointment::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/status', [DoctorAppointment::class, 'updateStatus'])->name('appointments.status');
    Route::get('/lab-tests', [DoctorAppointment::class, 'labTests'])->name('lab-tests.index');
    Route::post('/lab-tests/order', [DoctorAppointment::class, 'orderLabTest'])->name('lab-tests.order');
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/appointments/{appointment}/prescribe', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/appointments/{appointment}/prescribe', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions/{prescription}/pdf', [PrescriptionController::class, 'downloadPdf'])->name('prescriptions.pdf');
});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboard::class, 'index'])->name('dashboard');
    Route::get('/appointments', [PatientAppointment::class, 'index'])->name('appointments.index');
    Route::get('/appointments/book', [PatientAppointment::class, 'create'])->name('appointments.create');
    Route::post('/appointments/book', [PatientAppointment::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [PatientAppointment::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/cancel', [PatientAppointment::class, 'cancel'])->name('appointments.cancel');
    Route::get('/doctors/{departmentId}', [PatientAppointment::class, 'getDoctors'])->name('doctors.get');
    Route::get('/prescriptions', [PatientPrescription::class, 'index'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}', [PatientPrescription::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions/{prescription}/pdf', [PatientPrescription::class, 'downloadPdf'])->name('prescriptions.pdf');
    Route::get('/lab-reports', [LabReportController::class, 'index'])->name('lab-reports.index');
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
});

// Pharmacist Routes
Route::middleware(['auth', 'role:pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [PharmacistDashboard::class, 'index'])->name('dashboard');
    Route::get('/medicines', [PharmacistMedicine::class, 'index'])->name('medicines.index');
    Route::patch('/medicines/{medicine}/stock', [PharmacistMedicine::class, 'updateStock'])->name('medicines.stock');
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'downloadInvoice'])->name('sales.invoice');
});

// Receptionist Routes
Route::middleware(['auth', 'role:receptionist'])->prefix('receptionist')->name('receptionist.')->group(function () {
    Route::get('/dashboard', [ReceptionistDashboard::class, 'index'])->name('dashboard');
    Route::patch('/appointments/{appointment}/checkin', [ReceptionistDashboard::class, 'checkIn'])->name('checkin');
});

// Queue Routes (accessible by authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
    Route::get('/queue/data', [QueueController::class, 'getQueue'])->name('queue.data');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
