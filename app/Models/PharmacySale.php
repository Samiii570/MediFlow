<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacySale extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'pharmacist_id',
        'sale_date',
        'total_amount',
    ];

    protected function casts(): array
    {
        return [
            'sale_date' => 'date',
            'total_amount' => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacist()
    {
        return $this->belongsTo(User::class, 'pharmacist_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
