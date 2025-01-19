<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected $casts = [
        'medicines' => 'array',
        'quantities' => 'array',
        'dosages' => 'array',
    ];

    protected $fillable = [
        'medicines',
        'patient_id',
        'provider_id',
        'quantities',
        'dosages'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
