<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\AppointmentFormatterService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    //* ACCESSORS
    public function getFormattedDateAttribute()
    {
        return AppointmentFormatterService::getFormattedDate($this->attributes['date']);
    }

    public function getFormattedTimeAttribute()
    {
        return AppointmentFormatterService::getFormattedTime($this->attributes['time']);
    }

    public function getFormattedDurationAttribute()
    {
        return AppointmentFormatterService::getFormattedDuration($this->attributes['duration']);
    }
}
