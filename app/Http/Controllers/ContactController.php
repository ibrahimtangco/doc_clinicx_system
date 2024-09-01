<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated =
            $request->validate([
                'phone_number' => ['nullable', 'regex:/^(09|\+639)\d{9}$/', 'required_without:email'],
                'email' => ['nullable', 'email', 'required_without:phone_number'],
            ], [
                'phone_number.required_without' => 'The phone number is required when the email address is not provided.',
                'email.required_without' => 'The email address is required when the phone number is not provided.',
                'phone_number.regex' => 'The phone number format is invalid. It should be a valid Philippine number.',
                'email.email' => 'Please enter a valid email address.',
            ]);


        $contacts = Contact::create($validated);
        if (!$contacts) {
            emotify('error', 'Failed to add contact information');
            return redirect()->route('admin.settings');
        }
        emotify('success', 'Contact information added successfully');
        return redirect()->route('admin.settings');
    }

    public function update(Request $request)
    {
        if (array_key_exists('phone_number', $request->all())) {
            $validated =
                $request->validate([
                    'phone_number' => ['nullable', 'regex:/^(09|\+639)\d{9}$/'],
                ], [
                    'phone_number.regex' => 'The phone number format is invalid. It should be a valid Philippine number.',
                ]);

            $contactToUpdate = Contact::findOrFail($request->contact_id);
            $contactToUpdate->phone_number = $validated['phone_number'];
        } elseif (array_key_exists('email', $request->all())) {
            $validated =
                $request->validate([
                    'email' => ['nullable', 'email', 'required_without:phone_number'],
                ], [
                    'email.email' => 'Please enter a valid email address.',
                ]);

            $contactToUpdate = Contact::findOrFail($request->contact_id);
            $contactToUpdate->email = $validated['email'];
        }


        $result = $contactToUpdate->save();

        if (!$result) {
            emotify('error', 'Failed to update contact information');
            return redirect()->route('admin.settings');
        }
        emotify('success', 'Contact information updated successfully');
        return redirect()->route('admin.settings');
    }

    public function unset(Request $request)
    {
        $contactToUpdate = Contact::findOrFail($request->contact_id);

        if (array_key_exists('phone_number', $request->all())) {
            $contactToUpdate->phone_number = '';
            $contactToUpdate->save();
            return redirect()->route('admin.settings');
        } elseif (array_key_exists('email', $request->all())) {
            $contactToUpdate->email = '';
            $contactToUpdate->save();
            return redirect()->route('admin.settings');
        }
    }
}
