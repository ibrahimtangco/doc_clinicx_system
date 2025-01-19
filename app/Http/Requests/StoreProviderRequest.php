<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Auth\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
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
            // 'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'reg_number' => ['required', 'string', 'unique:providers,reg_number'],
            'title' => ['string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'middle_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZÀ-ÖØ-öø-ÿ\s\'-]+$/'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'street' => ['max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'userType' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*_#?&]/',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'reg_number.required' => 'The registration number field is required.',
            'reg_number.unique' => 'The registration number has already been taken.',
            'first_name.regex' => 'The first name can only contain letters, spaces, hyphens, and apostrophes.',
            'last_name.regex' => 'The last name can only contain letters, spaces, hyphens, and apostrophes.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}
