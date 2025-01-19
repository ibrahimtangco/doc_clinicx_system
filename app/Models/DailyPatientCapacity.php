<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPatientCapacity extends Model
{
    use HasFactory;

    protected $table = 'daily_patient_capacity';

    protected $fillable = [
        'date',
        'am_capacity',
        'pm_capacity'
    ];
}
