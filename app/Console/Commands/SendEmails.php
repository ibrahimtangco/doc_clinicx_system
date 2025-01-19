<?php

namespace App\Console\Commands;

use Log;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Console\Command;
use App\Notifications\ReminderAppointment;
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
        \Log::info('Starting to send reminders...');
        
        // Get reservations with an 'approved' status for tomorrow
        $approvedReservations = Reservation::whereDate('date', Carbon::tomorrow())->where('status', 'approved')->get();

        // Ensure that you only notify unique users
        $notifiedUsers = [];

        foreach ($approvedReservations as $reservation) {
            $user = $reservation->patient->user ?? null;

            if ($user && !in_array($user->id, $notifiedUsers)) {
                // Send the reminder to the user
                Notification::send($user, new ReminderAppointment($reservation));

                // Add the user ID to the notified list
                $notifiedUsers[] = $user->id;
            }
        }

        \Log::info('All reminders have been processed.');
    }
}
