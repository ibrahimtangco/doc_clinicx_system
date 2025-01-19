@component('mail::message')
# <span style="color: #03438a; font-weight: bold; font-size: 1.5rem;">New Reservation Request</span>

A new reservation request has been made by **{{ $patient_name }}**. Below are the details of the reservation:

---

## Reservation Details:
- **Date:** {{ \Carbon\Carbon::parse($reservation_date)->format('j F Y') }}
- **Schedule:** {{ $schedule }}
- **Service:** {{ $reservation_service }}

---

Please review the request and take action accordingly.

@component('mail::button', ['url' => $reservation_url, 'color' => 'primary'])
View Reservation
@endcomponent

Thank you for using **{{ config('app.name') }}**!

Best regards,
**The {{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
This email was generated automatically. If you have questions or need assistance, please contact us through our support channels.
@endcomponent
@endslot
@endcomponent
