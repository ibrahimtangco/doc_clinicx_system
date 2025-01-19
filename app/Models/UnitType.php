<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitType extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'abbreviation',
                'availability',
            ])
            ->useLogName('Unit of Measurement')
            ->logOnlyDirty(); // Log only the changed attributes
    }

    protected $fillable = [
        'name',
        'abbreviation',
        'availability'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
