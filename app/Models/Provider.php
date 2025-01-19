<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provider extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'title',
                'reg_number',
            ])
            ->useLogName('Dentist')
            ->logOnlyDirty(); // Log only the changed attributes
    }

    protected $fillable = [
        'user_id',
        'title',
        'reg_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescription()
    {
        return $this->hasMany(Prescription::class);
    }

    public function storeProviderDetails($validated, $user_id)
    {
        return
            Provider::create([
                'user_id' => $user_id,
                'title' => $validated['title'],
                'reg_number' => $validated['reg_number'],
            ]);
    }

    public function updateProviderDetails($validated, $provider_id)
    {
        $providerToUpdate = Provider::findOrFail($provider_id);

        return $providerToUpdate->update([
            'title' => $validated['title'],
            'reg_number' => $validated['reg_number'],
        ]);
    }
}
