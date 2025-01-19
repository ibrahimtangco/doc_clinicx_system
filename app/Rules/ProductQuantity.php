<?php

namespace App\Rules;

use Closure;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductQuantity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract the product_id from the attribute name
        $productId = request()->input(str_replace('quantity', 'product_id', $attribute));
        $product = Product::find($productId);

        if ($product == null) {
            $fail("Product field cannot be empty");
        } else {
            // Check if the product exists and if the requested quantity is less than or equal to the available stock
            if (!$product || $product->quantity < $value) {
                // $fail("Not enough stock for the $product->name");
                $fail("Not enough stock for the $product->name. Stock: $product->quantity");
            }
        }
    }
}
