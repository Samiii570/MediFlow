<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'token_no',
        'status',
        'follow_up_date',
        'follow_up_notes',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'follow_up_date' => 'date',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}
