<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'patient_id',
                'service_id',
                'preferred_schedule',
                'status',
                'queue_number',
                'date',
                'remarks'
            ])
            ->useLogName('Reservation')
            ->logOnlyDirty(); // Log only the changed attributes
    }
    
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function appointments()
    {
        return $this->hasOne(Appointment::class);
    }
}
