<x-master-layout>
	<section style="background-color: #f3f4f6; font-family: sans-serif; width:100%; height:100vh;">
		<div style="max-width: 576px; margin: 0 auto; padding-top: 30px; padding-bottom: 30px;">
			<div
				style="overflow: hidden; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
				<div style="width:100px; height: 100px; margin: 0 auto; padding: 24px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
					<?xml version="1.0" ?><svg viewBox="0 0 32 32" fill="#03438a" width="80px" height="80px" xmlns="http://www.w3.org/2000/svg"><title/><g data-name="Layer 15" id="Layer_15"><path class="cls-1" d="M16,31A15,15,0,1,1,31,16,15,15,0,0,1,16,31ZM16,3A13,13,0,1,0,29,16,13,13,0,0,0,16,3Z"/><path class="cls-1" d="M20.24,21.66l-4.95-4.95A1,1,0,0,1,15,16V8h2v7.59l4.66,4.65Z"/></g></svg>

				</div>
                <p style="color: #03438a; font-size: 30px; font-weight: 600; text-align:center; ">Appointment Reminder</p>
				<div style="padding: 24px;">
					<p style="color: #374151; font-size: 18px; margin-bottom: 16px;">Hi {{ $notifiable->full_name }},</p>
                    <p style="color: #374151; font-size: 16px; margin-bottom: 20px;">
						This is your reminder about your dental appointment tomorrow, {{ Carbon\Carbon::parse($appointment->date)->format('F j, Y') }} at {{ Carbon\Carbon::parse($appointment->time)->format('g:i A') }}.
					</p>
					<p style="color: #374151; font-size: 16px; margin-bottom: 0;">
						Click the confirm button below to confirm, otherwise click the cancel button.
					</p>
                    <div style="display: flex; gap:5px; margin-top: 10px">
                        <button style="background-color: green; padding:4px; color:white; width:100%;">Confirm</button>
                        <button style="background-color: red; padding:4px; color:white; width:100%;">Cancel</button>
                    </div>
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
