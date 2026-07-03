<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'specialization',
        'qualification',
        'consultation_fee',
    ];

    protected function casts(): array
    {
        return [
            'consultation_fee' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }
}
