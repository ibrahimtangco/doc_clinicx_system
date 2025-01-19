<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'telephone' => ['required', 'string', 'regex:/^(?:\+63\s?|0)9\d{2}[\s\-]?\d{3}[\s\-]?\d{4}$/'],
            'birthday' => ['required', 'date', 'date_format:Y-m-d'],
            'age' => ['required', 'integer', 'min:1'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s,.-]+$/'],
            'status' => ['required', 'in:Single,Married,Annulled,Widowed,Separated,Others'],
            'email' => [
                'sometimes',
                'string',
                'lowercase',
                'email',
                'max:255',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->patient->user_id)
                ]
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => 'The first name can only contain letters, spaces, hyphens, and apostrophes.',
            'last_name.regex' => 'The last name can only contain letters, spaces, hyphens, and apostrophes.',
            'telephone.required' => 'The phone number is required.',
            'telephone.regex' => 'The telephone number must be a valid Philippine mobile number.',
            'email.unique' => 'This email address is already registered.',
            'password.min' => 'Use 8 characters or more for your password.',
            'password.regex' => 'Use 8 or more characters with a mix of letters, numbers, and symbols.',
        ];
    }
}
