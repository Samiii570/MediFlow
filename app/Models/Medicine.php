<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_name',
        'stock',
        'price',
        'expiry_date',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function prescriptionMedicines()
    {
        return $this->hasMany(PrescriptionMedicine::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function getNameAttribute()
    {
        return $this->medicine_name;
    }

    public function isExpiringSoon(): bool
    {
        return $this->expiry_date->diffInDays(now()) <= 30 && $this->expiry_date->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function isLowStock(): bool
    {
        return $this->stock <= 10;
    }
}
