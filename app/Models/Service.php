<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'price',
                'availability',
            ])
            ->useLogName('Service')
            ->logOnlyDirty(); // Log only the changed attributes
    }

    protected $fillable = [
        'name',
        'description',
        'price',
        'availability'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours} hr {$minutes} mins";
        } elseif ($hours > 0) {
            return "{$hours} hr";
        } else {
            return "{$minutes} mins";
        }
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, '.', ',');
    }

    public function storeServicedetails($validated)
    {
        return Service::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'availability' =>
            array_key_exists('availability', $validated) ? ($validated['availability'] == true ? 1 : 0) : 0,
        ]);
    }

    public function updateServiceDetails($validated, $service_id)
    {
        $serviceToUpdate = Service::findOrFail($service_id);

        return $serviceToUpdate->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'availability' => array_key_exists('availability', $validated) ? ($validated['availability'] == true ? 1 : 0) : 0,
        ]);
    }
}
