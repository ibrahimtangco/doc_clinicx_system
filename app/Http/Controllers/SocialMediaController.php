<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function create()
    {
        return view('admin.social_media.create')->with('title', 'Socials | Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => [
                'required',
                'string',
                'max:50',
                'unique:social_media,platform',
            ],
            'username' => 'nullable|string|max:100',
            'url' => 'required|max:255|active_url'
        ], [
            'platform.unique' => 'This platform already exists. Only one entry per platform is allowed.'
        ]);

        $result =
            SocialMedia::create($validated);

        if (!$result) {
            emotify('error', 'Failed to create social media account.');
            return redirect()->back();
        } else {
            emotify('success', 'Social media account created.');
            return redirect()->route('admin.settings');
        }
    }

    public function edit(SocialMedia $social_media)
    {

        return view('admin.social_media.edit', compact('social_media'))->with('title', 'Social | Update Details');
    }

    public function update(SocialMedia $social_media, Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50|unique:social_media,platform,' . $social_media->id,
            'username' => 'nullable|string|max:100|regex:/^[a-zA-Z0-9._\-\s]+$/',
            'url' => 'required|max:255|active_url',
            'status' => 'sometimes'
        ]);
        if (!isset($validated['status'])) {
            $validated['status'] = 0;
        }
        else {
            $validated['status'] = 1;
        }
        // dd($validated);
        $result = $social_media->update($validated);

        if (!$result) {
            emotify('error', 'Failed to update social media details.');
            return redirect()->back();
        } else {
            emotify('success', 'Social media account details updated.');
            return redirect()->route('admin.settings');
        }
    }
}
