<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'unit_type_id' => 'required|exists:unit_types,id',
            'description' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'buying_price' => 'required|decimal:2,4',
            'selling_price' => 'required|decimal:2,4',
            'status' => 'sometimes'
        ];
    }
}
