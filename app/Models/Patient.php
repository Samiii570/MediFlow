<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_group',
        'gender',
        'dob',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function pharmacySales()
    {
        return $this->hasMany(PharmacySale::class);
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }

    public function getPhoneAttribute()
    {
        return $this->user->phone ?? '';
    }

    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }
}
