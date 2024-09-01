<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\Contact;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        $footer = Footer::first();
        return view('admin.settings.settings', compact('contacts', 'footer'));
    }
}
