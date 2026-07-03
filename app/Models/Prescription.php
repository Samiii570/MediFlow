<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'notes',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->hasOneThrough(
            Doctor::class,
            Appointment::class,
            'id',
            'id',
            'appointment_id',
            'doctor_id'
        );
    }

    public function patient()
    {
        return $this->hasOneThrough(
            Patient::class,
            Appointment::class,
            'id',
            'id',
            'appointment_id',
            'patient_id'
        );
    }

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicines')
            ->withPivot(['dosage', 'duration', 'frequency'])
            ->withTimestamps();
    }
}
