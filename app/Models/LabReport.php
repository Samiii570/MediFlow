<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'report_file',
        'remarks',
    ];

    public function labTest()
    {
        return $this->belongsTo(LabTest::class, 'test_id');
    }
}
