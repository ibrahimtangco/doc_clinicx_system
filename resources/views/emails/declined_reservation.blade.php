@component('mail::message')
# <span style="color: #DC3545; font-weight: bold; font-size: 1.5rem;">Reservation Declined</span>

Hello {{ $user->full_name }},

We regret to inform you that your reservation request could not be approved at this time. Below is the reason provided for the decline:

@component('mail::panel')
### Reason for Decline:
<span style="color: #721c24;">{{ $reservation->remarks }}</span>
@endcomponent

---

If you have any questions or require further assistance, feel free to get in touch with us. We are here to help.

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

We sincerely apologize for any inconvenience this may have caused.
Thank you for understanding.

Warm regards,
**{{ config('app.name') }} Team**

@slot('footer')
@component('mail::subcopy')
This is an automated email. Please do not reply to this message.
If you wish to contact us, use the information provided above.
@endcomponent
@endslot
@endcomponent
