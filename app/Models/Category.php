<?php

namespace App\Models;


use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'description',
                'availability',
            ])
            ->useLogName('Category')
            ->logOnlyDirty(); // Log only the changed attributes
    }


    protected $fillable = [
        'name',
        'description',
        'availability'
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function getFormattedAvailabilityAttribute()
    {
        if (!$this->availability) {
            return 'Inactive';
        }

        return 'Active';
    }

    public function storeCategory($category)
    {
        return Category::create($category);
    }

    public function updateCategory($category, $category_id)
    {
        $categoryToUpdate = Category::findOrFail($category_id);

        $category = $categoryToUpdate->update([
            'name' => $category['name'],
            'description' => $category['description'],
            'availability' =>
            array_key_exists('availability', $category) ? ($category['availability'] == true ? 1 : 0) : 0,
        ]);

        return $category;
    }

    public function searchCategory($search)
    {
        $search = strtolower($search);

        return Category::where('name', 'LIKE', "%$search%")
            ->orWhere(function ($query) use ($search) {
                if (stripos('active', $search) !== false) {
                    $query->orWhere('availability', 1);
                }
                if (stripos('inactive', $search) !== false) {
                    $query->orWhere('availability', 0);
                }
            })
            ->get();
    }
}
