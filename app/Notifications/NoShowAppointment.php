<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\Appointment;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NoShowAppointment extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Appointment $appointment)
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

        return (new MailMessage)
            ->subject('Your Service was not Completed')
            ->markdown('emails.no_show_appointment', [
                'appointment' => $this->appointment,
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
