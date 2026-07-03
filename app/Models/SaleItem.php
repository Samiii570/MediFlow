<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'medicine_id',
        'quantity',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
        ];
    }

    public function sale()
    {
        return $this->belongsTo(PharmacySale::class, 'sale_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }
}
