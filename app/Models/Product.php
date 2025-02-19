<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'category_id',
                'unit_type_id',
                'description',
                'quantity',
                'minimum_stock',
                'buying_price',
                'selling_price',
                'status'
            ])
            ->useLogName('Product')
            ->logOnlyDirty(); // Log only the changed attributes
    }

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }


    public function storeProduct($product)
    {

        return Product::create($product);
    }

    public function updateProduct($validated, $product)
    {
        return $product->update([
            "name" => $validated['name'],
            "category_id" => $validated['category_id'],
            "unit_type_id" => $validated['unit_type_id'],
            "description" => $validated['description'],
            "quantity" => $validated['quantity'],
            "minimum_stock" => $validated['minimum_stock'],
            "buying_price" => $validated['buying_price'],
            "selling_price" => $validated['selling_price'],
            'status' => array_key_exists('status', $validated) ? ($validated['status'] == true ? 1 : 0) : 0
        ]);
    }

    public function searchProduct($search)
    {

        return
            Product::where('products.name', 'LIKE', '%' . $search . '%')
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                })
                ->get();
    }
}
