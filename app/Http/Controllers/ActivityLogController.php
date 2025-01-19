<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    //
    public function displayLogs()
    {
        // return all the logs, sort it based on ID.
        $activityLogs = Activity::orderBy('id', 'desc')->get();

        return view('admin.activity_logs.activity_logs', compact('activityLogs'))->with('title', 'Audit Trails | View List');
    }
}
