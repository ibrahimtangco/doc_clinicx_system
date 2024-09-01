<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function update(Request $request, Footer $footer)
    {
        $validated = $request->validate([
            'description' => 'string|max:100'
        ]);

        $result = $footer->update($validated);
        if (!$result) {
            emotify('error', 'Failed to update footer\'s information');
            return redirect()->route('admin.settings');
        } else {
            emotify('success', 'Footer\'s information updated successfully');
            return redirect()->route('admin.settings');
        }
    }
}
