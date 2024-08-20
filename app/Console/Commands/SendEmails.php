<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Console\Command;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Notification;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:send_email_reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminder the day before the patients\' scheduled appointment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info("Sending Reminder");

        $appointments = Appointment::whereDate('date', Carbon::tomorrow())->get();

        foreach ($appointments as $appointment) {
            $appointment->user->notify(new AppointmentReminder($appointment));
        }
    }
}
