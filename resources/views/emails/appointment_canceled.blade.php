<x-master-layout>
    <section style="background-color: #f3f4f6; font-family: sans-serif; width: 100%; height: 100vh;">
        <div style="max-width: 576px; margin: 0 auto; padding-top: 30px; padding-bottom: 30px;">
            <div style="overflow: hidden; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                <div style="background-color: #b91c1c; padding: 24px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h1 style="color: #ffffff; font-size: 24px; font-weight: bold; margin: 0;">Appointment Cancelled</h1>
                </div>
                <div style="padding: 24px;">
                    <p style="color: #374151; font-size: 18px; margin-bottom: 16px;">Dear {{ $notifiable->full_name }},</p>
                    <p style="color: #374151; font-size: 16px; margin-bottom: 20px;">
                        Your appointment for {{ Carbon\Carbon::parse($appointment->date)->format('F, j Y') }} at {{ Carbon\Carbon::parse($appointment->time)->format('g:i A') }} has been cancelled. <strong>Reason:</strong>
                    </p>
                    <div style="margin: 20px 0; background-color: #f3f4f6; padding: 12px; border-radius: 4px; color:black; font-size: 14px;">
                        @if (!$appointment->remark)
                            Appointment Cancelled.
                        @else
                            {{ $appointment->remark }}
                        @endif
                    </div>
                    <div style="width:100%; display: flex;">
                        <a href="http://127.0.0.1:8000/dashboard" style="text-decoration:none; text-align: center; color: white; background-color: #b91c1c; padding: 10px; font-size:13px; width: 100%;" target="_blank">SCHEDULE NEW APPOINTMENT</a>
                    </div>
                    <p style="color: #374151; font-size: 16px; margin-top: 20px; margin-bottom: 20px;">
                        Please contact us if you have any questions.
                    </p>
                    <p style="color: #374151; font-size: 16px; margin-bottom: 0;">
                        Thank you for your understanding.
                    </p>
                </div>
               <footer style="border-top: 1px solid #ddd; padding: 16px 0; margin-top: 24px;">
					<div style="width:100%;">
						<p style="font-size: 14px; color: #6b7280; text-align: center;">
							© 2024 DocClinicx —
							<a href="https://app.facebook.com/filarcarabenadentalclinic" style="color: #6366f1; text-decoration: underline;"
								target="_blank">Filarca-Rabena</a>
						</p>
					</div>
				</footer>
            </div>
        </div>
    </section>
</x-master-layout>
