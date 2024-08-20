<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentBooked extends Notification
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
        $service = Service::findOrFail($this->data['service_id']);
        $formattedDate = Carbon::parse($this->data['date'])->format('F j, Y');
        $formattedTime = Carbon::parse($this->data['time'])->format('g:i A');

        return (new MailMessage)
            ->subject('New Dental Appointment Booked')
            ->markdown('emails.appointment_booked', [
                'service' => $service,
                'formattedDate' => $formattedDate,
                'formattedTime' => $formattedTime,
                'patient' => $notifiable
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
