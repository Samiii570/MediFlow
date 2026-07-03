<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\LabTest;
use App\Models\PharmacySale;
use App\Models\SaleItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $password = Hash::make('password');

        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@mediflow.com',
            'password' => $password,
            'phone' => '555-0100',
            'role' => 'admin',
        ]);

        // Create Receptionist
        User::create([
            'name' => 'Sarah Receptionist',
            'email' => 'receptionist@mediflow.com',
            'password' => $password,
            'phone' => '555-0101',
            'role' => 'receptionist',
        ]);

        // Create Pharmacist
        $pharmacistUser = User::create([
            'name' => 'Mike Pharmacist',
            'email' => 'pharmacist@mediflow.com',
            'password' => $password,
            'phone' => '555-0102',
            'role' => 'pharmacist',
        ]);

        // Create Departments
        $departments = [];
        $deptData = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system care'],
            ['name' => 'Neurology', 'description' => 'Brain and nervous system disorders'],
            ['name' => 'Orthopedics', 'description' => 'Bone, joint, and musculoskeletal system care'],
            ['name' => 'Pediatrics', 'description' => 'Medical care for infants, children, and adolescents'],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nail conditions'],
            ['name' => 'General Medicine', 'description' => 'Primary care and general health checkups'],
            ['name' => 'ENT', 'description' => 'Ear, nose, and throat conditions'],
            ['name' => 'Ophthalmology', 'description' => 'Eye care and vision disorders'],
            ['name' => 'Psychiatry', 'description' => 'Mental health and behavioral disorders'],
            ['name' => 'Urology', 'description' => 'Urinary tract and male reproductive system care'],
        ];

        foreach ($deptData as $dept) {
            $departments[] = Department::create($dept);
        }

        // Create Doctors
        $doctorNames = [
            ['name' => 'Dr. James Wilson', 'specialization' => 'Interventional Cardiology', 'qualification' => 'MBBS, MD, DM Cardiology', 'fee' => 1500],
            ['name' => 'Dr. Emily Chen', 'specialization' => 'Clinical Neurology', 'qualification' => 'MBBS, MD Neurology', 'fee' => 1200],
            ['name' => 'Dr. Robert Kumar', 'specialization' => 'Joint Replacement', 'qualification' => 'MBBS, MS Orthopedics', 'fee' => 1800],
            ['name' => 'Dr. Maria Garcia', 'specialization' => 'Pediatric Medicine', 'qualification' => 'MBBS, MD Pediatrics', 'fee' => 800],
            ['name' => 'Dr. David Park', 'specialization' => 'Cosmetic Dermatology', 'qualification' => 'MBBS, MD Dermatology', 'fee' => 1000],
            ['name' => 'Dr. Priya Sharma', 'specialization' => 'General Practice', 'qualification' => 'MBBS, DNB Family Medicine', 'fee' => 500],
            ['name' => 'Dr. Thomas Brown', 'specialization' => 'ENT Surgery', 'qualification' => 'MBBS, MS ENT', 'fee' => 900],
            ['name' => 'Dr. Lisa Wang', 'specialization' => 'Retinal Surgery', 'qualification' => 'MBBS, MS Ophthalmology', 'fee' => 1100],
            ['name' => 'Dr. Ahmed Hassan', 'specialization' => 'Clinical Psychiatry', 'qualification' => 'MBBS, MD Psychiatry', 'fee' => 1300],
            ['name' => 'Dr. Rachel Moore', 'specialization' => 'Urological Surgery', 'qualification' => 'MBBS, MCh Urology', 'fee' => 1400],
        ];

        $doctors = [];
        foreach ($doctorNames as $i => $doc) {
            $user = User::create([
                'name' => $doc['name'],
                'email' => strtolower(str_replace([' ', '.'], ['.', ''], $doc['name'])) . '@mediflow.com',
                'password' => $password,
                'phone' => '555-' . str_pad(1000 + $i, 4, '0', STR_PAD_LEFT),
                'role' => 'doctor',
            ]);

            $deptIndex = $i % count($departments);
            $doctors[] = Doctor::create([
                'user_id' => $user->id,
                'department_id' => $departments[$deptIndex]->id,
                'specialization' => $doc['specialization'],
                'qualification' => $doc['qualification'],
                'consultation_fee' => $doc['fee'],
            ]);
        }

        // Create Patients
        $patients = [];
        $patientNames = [
            ['name' => 'John Smith', 'gender' => 'male', 'blood' => 'A+'],
            ['name' => 'Emma Johnson', 'gender' => 'female', 'blood' => 'B+'],
            ['name' => 'Michael Davis', 'gender' => 'male', 'blood' => 'O+'],
            ['name' => 'Sophia Martinez', 'gender' => 'female', 'blood' => 'AB+'],
            ['name' => 'William Brown', 'gender' => 'male', 'blood' => 'A-'],
            ['name' => 'Olivia Wilson', 'gender' => 'female', 'blood' => 'B-'],
            ['name' => 'James Taylor', 'gender' => 'male', 'blood' => 'O-'],
            ['name' => 'Isabella Anderson', 'gender' => 'female', 'blood' => 'AB-'],
        ];

        foreach ($patientNames as $i => $p) {
            $user = User::create([
                'name' => $p['name'],
                'email' => strtolower(str_replace(' ', '.', $p['name'])) . '@email.com',
                'password' => $password,
                'phone' => '555-' . str_pad(2000 + $i, 4, '0', STR_PAD_LEFT),
                'role' => 'patient',
            ]);

            $patients[] = Patient::create([
                'user_id' => $user->id,
                'blood_group' => $p['blood'],
                'gender' => $p['gender'],
                'dob' => Carbon::now()->subYears(rand(18, 65))->subDays(rand(0, 365)),
                'address' => fake()->address(),
            ]);
        }

        // Create Medicines
        $medicineNames = [
            ['name' => 'Paracetamol 500mg', 'stock' => 500, 'price' => 25, 'expiry' => '+18 months'],
            ['name' => 'Amoxicillin 250mg', 'stock' => 200, 'price' => 85, 'expiry' => '+12 months'],
            ['name' => 'Metformin 500mg', 'stock' => 300, 'price' => 120, 'expiry' => '+24 months'],
            ['name' => 'Amlodipine 5mg', 'stock' => 150, 'price' => 95, 'expiry' => '+20 months'],
            ['name' => 'Omeprazole 20mg', 'stock' => 8, 'price' => 150, 'expiry' => '+8 months'],
            ['name' => 'Cetirizine 10mg', 'stock' => 400, 'price' => 45, 'expiry' => '+15 months'],
            ['name' => 'Ibuprofen 400mg', 'stock' => 350, 'price' => 55, 'expiry' => '+10 months'],
            ['name' => 'Azithromycin 500mg', 'stock' => 5, 'price' => 200, 'expiry' => '+3 months'],
            ['name' => 'Pantoprazole 40mg', 'stock' => 180, 'price' => 130, 'expiry' => '+22 months'],
            ['name' => 'Losartan 50mg', 'stock' => 220, 'price' => 110, 'expiry' => '+16 months'],
            ['name' => 'Salbutamol Inhaler', 'stock' => 75, 'price' => 350, 'expiry' => '-1 months'],
            ['name' => 'Dexamethasone 4mg', 'stock' => 90, 'price' => 180, 'expiry' => '+6 months'],
            ['name' => 'Metoprolol 50mg', 'stock' => 160, 'price' => 75, 'expiry' => '+14 months'],
            ['name' => 'Diclofenac Gel', 'stock' => 120, 'price' => 65, 'expiry' => '+9 months'],
            ['name' => 'ORS Sachets', 'stock' => 500, 'price' => 15, 'expiry' => '+30 months'],
        ];

        $medicines = [];
        foreach ($medicineNames as $m) {
            $medicines[] = Medicine::create([
                'medicine_name' => $m['name'],
                'stock' => $m['stock'],
                'price' => $m['price'],
                'expiry_date' => Carbon::parse($m['expiry']),
            ]);
        }

        // Create Appointments (past 30 days and today)
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $todayAppointments = [];

        for ($day = -30; $day <= 0; $day++) {
            $date = Carbon::now()->addDays($day);
            $numAppointments = ($day == 0) ? 6 : rand(2, 5);

            for ($i = 0; $i < $numAppointments; $i++) {
                $patient = $patients[array_rand($patients)];
                $doctor = $doctors[array_rand($doctors)];

                $token = Appointment::where('doctor_id', $doctor->id)
                    ->where('appointment_date', $date)
                    ->count() + 1;

                $status = ($day < -2) ? $statuses[array_rand([2, 3])] : $statuses[array_rand([0, 1, 2])];

                $appt = Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'appointment_date' => $date,
                    'token_no' => $token,
                    'status' => $status,
                    'follow_up_date' => ($i == 0 && $day >= -5) ? $date->copy()->addDays(14) : null,
                    'follow_up_notes' => ($i == 0 && $day >= -5) ? 'Follow up for ongoing treatment' : null,
                ]);

                if ($day == 0) {
                    $todayAppointments[] = $appt;
                }

                // Create prescriptions for completed appointments
                if ($status === 'completed' && rand(0, 1)) {
                    $prescription = Prescription::create([
                        'appointment_id' => $appt->id,
                        'diagnosis' => $this->getDiagnosis(),
                        'notes' => $this->getNotes(),
                    ]);

                    // Add 1-4 medicines to prescription
                    $numMeds = rand(1, 4);
                    $usedMeds = [];
                    for ($m = 0; $m < $numMeds; $m++) {
                        do {
                            $med = $medicines[array_rand($medicines)];
                        } while (in_array($med->id, $usedMeds));
                        $usedMeds[] = $med->id;

                        PrescriptionMedicine::create([
                            'prescription_id' => $prescription->id,
                            'medicine_id' => $med->id,
                            'dosage' => $this->getDosage(),
                            'duration' => $this->getDuration(),
                            'frequency' => $this->getFrequency(),
                        ]);
                    }
                }

                // Create lab tests for some completed appointments
                if ($status === 'completed' && rand(0, 2)) {
                    $labStatus = $statuses[array_rand([1, 2])];
                    LabTest::create([
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'test_name' => $this->getTestName(),
                        'status' => $labStatus,
                    ]);
                }
            }
        }

        // Create pharmacy sales
        for ($day = -15; $day <= 0; $day++) {
            $numSales = rand(0, 3);
            for ($s = 0; $s < $numSales; $s++) {
                $patient = $patients[array_rand($patients)];
                $total = 0;
                $sale = PharmacySale::create([
                    'patient_id' => $patient->id,
                    'pharmacist_id' => $pharmacistUser->id,
                    'sale_date' => Carbon::now()->addDays($day),
                    'total_amount' => 0,
                ]);

                $numItems = rand(1, 4);
                for ($i = 0; $i < $numItems; $i++) {
                    $med = $medicines[array_rand($medicines)];
                    $qty = rand(1, 5);
                    $subtotal = $qty * $med->price;
                    $total += $subtotal;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'medicine_id' => $med->id,
                        'quantity' => $qty,
                        'unit_price' => $med->price,
                    ]);
                }

                $sale->update(['total_amount' => $total]);
            }
        }
    }

    private function getDiagnosis(): string
    {
        $diagnoses = [
            'Acute Upper Respiratory Tract Infection',
            'Type 2 Diabetes Mellitus - Uncontrolled',
            'Essential Hypertension Stage 2',
            'Acute Gastroenteritis',
            'Migraine without Aura',
            'Iron Deficiency Anemia',
            'Bronchial Asthma - Moderate Persistent',
            'Hypothyroidism',
            'Generalized Anxiety Disorder',
            'Acute Low Back Pain',
            'Seasonal Allergic Rhinitis',
            'Dyspepsia - Functional',
        ];
        return $diagnoses[array_rand($diagnoses)];
    }

    private function getNotes(): string
    {
        $notes = [
            'Patient advised rest and adequate fluid intake. Review after 1 week.',
            'Strict dietary control advised. Regular monitoring of blood sugar levels.',
            'Continue medication. Lifestyle modifications recommended.',
            'Follow up in 2 weeks if symptoms persist.',
            'Patient counseled on medication compliance.',
            'Referred for further investigation.',
            'Stress management techniques discussed with patient.',
            'Physical therapy recommended alongside medication.',
        ];
        return $notes[array_rand($notes)];
    }

    private function getDosage(): string
    {
        return fake()->randomElement(['1 tablet', '2 tablets', '5ml', '10ml', '1 capsule', '2 capsules', '1 puff']);
    }

    private function getDuration(): string
    {
        return fake()->randomElement(['5 days', '7 days', '10 days', '14 days', '21 days', '30 days', '2 months', '3 months']);
    }

    private function getFrequency(): string
    {
        return fake()->randomElement(['Once daily', 'Twice daily', 'Three times daily', 'Four times daily', 'Every 8 hours', 'Every 12 hours', 'As needed']);
    }

    private function getTestName(): string
    {
        $tests = [
            'Complete Blood Count (CBC)',
            'Lipid Profile',
            'Blood Sugar Fasting',
            'Thyroid Function Test',
            'Liver Function Test',
            'Kidney Function Test',
            'Urinalysis',
            'HbA1c',
            'ECG',
            'Chest X-Ray',
            'ESR',
            'Vitamin D Level',
        ];
        return $tests[array_rand($tests)];
    }
}
