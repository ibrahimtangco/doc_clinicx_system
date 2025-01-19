<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\Reservation;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DeclinedReservation extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Reservation $reservation)
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
            ->subject('Your Reservation has been Declined')
            ->markdown('emails.declined_reservation', [
                'reservation' => $this->reservation,
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
