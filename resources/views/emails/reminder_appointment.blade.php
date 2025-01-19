@component('mail::message')
# Appointment Reminder

Hello {{ $user->full_name }},

This is a friendly reminder about your upcoming appointment. Please find the details below:

---

## Appointment Details:
- **Service:** {{ $reservation->service->name }}
- **Date:** {{ \Carbon\Carbon::parse($reservation->date)->format('l, F j, Y') }}
- **Schedule:** {{ $reservation->preferred_schedule }}
- **Queue Number:**
  <span style="background-color: #03438a; color: white; padding: 5px 10px; border-radius: 5px; font-size: 1rem;">{{ $reservation->queue_number }}</span>

---

To ensure a smooth experience, we kindly request that you arrive at least **10 minutes before** your scheduled time.

If you have any questions or concerns, feel free to contact us.

Thank you for choosing **{{ config('app.name') }}**. We look forward to serving you!

Warm regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
This is an automated email reminder. If you need assistance, please contact our support team.
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
