<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReminderAppointment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Reservation $approvedReservation)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $socials = SocialMedia::all();
        $contacts = Contact::all();

        $formattedDate = Carbon::parse($this->approvedReservation->date)->format('j F Y');
        return (new MailMessage)
            ->subject("Reminder: Upcoming Appointment on {$formattedDate}")
            ->markdown('emails.reminder_appointment', [
                'reservation' => $this->approvedReservation,
                'user' => $notifiable,
                'socials' => $socials,
                'contacts' => $contacts
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
