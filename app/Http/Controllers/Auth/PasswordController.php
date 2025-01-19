<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',               // Must contain at least one lowercase letter
                'regex:/[A-Z]/',               // Must contain at least one uppercase letter
                'regex:/[0-9]/',               // Must contain at least one number
                'regex:/[@$!%*_#?&]/',          // Must contain at least one special character
                'confirmed',                   // Must match the password confirmation field
            ],
        ]);


        $successChange = $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        if (!$successChange) {
            emotify('error', 'Failed to change password');
        }
        emotify('success', 'Password changed successfully');

        return back()->with('status', 'password-updated');
    }
}
