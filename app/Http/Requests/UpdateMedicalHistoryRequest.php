<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalHistoryRequest extends FormRequest
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
            'edit_id' => 'required|exists:medical_history,id',
            'edit_condition' => 'required|string|max:255',
            'edit_diagnosed_date' => 'required|date',
            'edit_treatment' => 'nullable|string',
            'edit_status' => 'required|string',
            'edit_description' => 'nullable|string'
        ];
    }
}
