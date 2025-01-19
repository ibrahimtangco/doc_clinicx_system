@component('mail::message')
# <span style="color: #28a745; font-weight: bold; font-size: 1.5rem;">Reservation Approved</span>

Hello {{ $user->full_name }},

We’re excited to inform you that your reservation request has been **approved**! Here are the details of your reservation:

---

## Reservation Details:
- **Date:** {{ \Carbon\Carbon::parse($reservation->date)->format('j F Y') }}
- **Schedule:** {{ $reservation->preferred_schedule }}
- **Service:** {{ $reservation->service->name }}
- **Queue Number:**
  <span style="text-decoration: underline;">{{ $reservation->queue_number }}</span>

---

We are thrilled to have you and look forward to providing excellent service. For more information or to view your reservation details, click the button below:

@component('mail::button', ['url' => $reservationUrl, 'color' =>'success'])
View Reservation Details
@endcomponent

Thank you for choosing **{{ config('app.name') }}**. We appreciate your trust in us!

Warm regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
If you have any questions or need assistance, please contact us through our support channels.

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

This email was generated automatically—do not reply directly to this message.
@endcomponent
@endslot
@endcomponent
