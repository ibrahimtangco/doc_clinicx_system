@component('mail::message')
# Hello {{ $user->full_name }},

We’re delighted to inform you that your scheduled service has been successfully completed. Below are the details of your appointment:

---

## Appointment Details:
- **Service:** {{ $appointment->reservation->service->name }}
- **Date:** {{ Carbon\Carbon::parse($appointment->reservation->date)->format('j F Y') }}
- **Schedule:** {{ $appointment->reservation->preferred_schedule }}

@if ($appointment->remarks)
### Additional Remarks:
@component('mail::panel')
{{ $appointment->remarks }}
@endcomponent
@endif

---

We hope the service met your expectations! If you have any questions, feedback, or need further assistance, feel free to contact us.

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

Thank you for choosing **{{ config('app.name') }}**. We value your trust and look forward to serving you again!

Warm regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
This email was generated automatically. For any inquiries, please contact us directly through our website or support channels.
@endcomponent
@endslot
@endcomponent
