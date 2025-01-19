<?php

namespace App\Notifications;

use App\Models\Contact;
use App\Models\Reservation;
use App\Models\SocialMedia;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReservation extends Notification implements ShouldQueue
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

        $reservationUrl = route('admin.reservation.list');
        return (new MailMessage)
            ->subject('New Reservation Request')
            ->greeting("Hello {$notifiable->full_name}")
            ->markdown('emails.new_reservation', [
                'patient_name' => $this->reservation->patient->user->full_name,
                'reservation_date' => $this->reservation->date,
                'schedule' => $this->reservation->preferred_schedule,
                'reservation_service' => $this->reservation->service->name,
                'reservation_url' => $reservationUrl,
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
