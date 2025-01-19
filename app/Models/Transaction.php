<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'transaction_code',
                'total_amount',
            ])
            ->useLogName('Transaction')
            ->logOnlyDirty(); // Log only the changed attributes

    }
    protected $fillable = [
        'transaction_code',
        'total_amount'
    ];

    // Relationship to transaction details
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Custom accessor to get the total quantity of all products in a transaction
    public function getTotalQuantityAttribute()
    {
        // Sum the quantity from all related transaction details
        return $this->details()->sum('quantity');
    }
}
