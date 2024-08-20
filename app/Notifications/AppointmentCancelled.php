<?php

namespace App\Notifications;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCancelled extends Notification
{
    use Queueable;
    protected $appointment;
    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
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

    private function getFullName($patient)
    {
        if ($patient['middle_name']) {
            $middleInitial = Str::ucfirst(substr($patient['middle_name'], 0, 1));
            return $patient['first_name'] . ' ' . $middleInitial . '. ' . $patient['last_name'];
        } else {
            return $patient['first_name'] . ' ' . $patient['last_name'];
        }
    }

    private function formatNote($appointment)
    {
        return $appointment->remark ?? null;
    }

    private function formatDate($appointment)
    {
        $date = Carbon::parse($appointment->date)->format('F j, Y');
        $time = Carbon::parse($appointment->time)->format('g:i A');

        return $date . ' at ' . $time;
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Dental Appointment Cancelled')
            ->markdown('emails.appointment_canceled', [
                'appointment' => $this->appointment,
                'notifiable' => $notifiable
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
