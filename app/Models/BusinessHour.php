<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getTimesPeriodAttribute()
    {
        $times = CarbonInterval::minutes($this->step)->toPeriod($this->from, $this->to)->toArray();
        // step = 60, from = 9:00, to = 17:00
        // $times = [9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00 16:00, 17:00]
        return array_map(function ($time) {
            // Check if the current day is equal to $this->day
            // 1. $time = 9:00
            if ($this->day == today()->format('l')) {
                // Check if $time is not past the current time
                if (!$time->isPast()) {
                    return $time->format('H:i');
                }
            } else {
                return $time->format('H:i');
            }
        }, $times);
    }
}
