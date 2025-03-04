<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\Reservation;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ApprovedReservation extends Notification implements ShouldQueue
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
        $url = route('user.reservation.list');

        return (new MailMessage)
            ->subject('Your Reservation Has Been Approved')
            ->markdown('emails.approved_reservation', [
                'user' => $notifiable,
                'reservation' => $this->reservation,
                'reservationUrl' => $url,
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
