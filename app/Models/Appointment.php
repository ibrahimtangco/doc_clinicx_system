<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'queue_number',
        'status',
        'remarks'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Access user through reservation
    public function user()
    {
        return $this->reservation->user();
    }

    // Access patient through reservation
    public function patient()
    {
        return $this->reservation->patient();
    }

    // Access service through reservation
    public function service()
    {
        return $this->reservation->service();
    }
}
