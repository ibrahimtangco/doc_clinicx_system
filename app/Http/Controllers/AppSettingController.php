<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Contact;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $footer = Footer::first();
        $socials = SocialMedia::all();
        return view('admin.settings.settings', compact('contacts', 'footer', 'socials'))->with('title', 'Settings | Update Details');
    }
}
