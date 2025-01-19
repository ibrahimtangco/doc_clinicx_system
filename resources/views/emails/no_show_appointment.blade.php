@component('mail::message')
# <span style="color: #DC3545; font-weight: bold; font-size: 1.5rem;">Important: Missed Appointment</span>

Hello {{ $user->full_name }},

We regret to inform you that your scheduled service was either not completed or you were marked as a **"No Show"**. Here are the details of your appointment:

---

## Appointment Details:
- **Service:** {{ $appointment->reservation->service->name }}
- **Date:** {{ \Carbon\Carbon::parse($appointment->reservation->date)->format('j F Y') }}
- **Schedule:** {{ $appointment->reservation->preferred_schedule }}

---

We understand that unforeseen circumstances can arise. Please contact us at your earliest convenience to reschedule your appointment.

@component('mail::button', ['url' => route('user.dashboard'), 'color' => 'error'])
Reschedule Appointment
@endcomponent

If you have any questions or concerns, feel free to reach out to our team. We’re here to assist you.

Thank you for your understanding, and we look forward to seeing you soon.

Warm regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
This is an automated email notification. For assistance, please contact our support team directly through the provided channels.
@endcomponent

## Stay Connected
@foreach ($socials as $social)
- <strong>{{ ucfirst($social->platform) }}:</strong> [{{ $social->username }}]({{ $social->url }})
@endforeach

## Contact Us
@foreach ($contacts as $contact)
- **Phone**: {{ $contact->phone_number }}
- **Email**: [{{ $contact->email }}](mailto:{{ $contact->email }})
@endforeach

---
@endslot
@endcomponent
