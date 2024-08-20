<x-master-layout>
	<section style="background-color: #f3f4f6; font-family: sans-serif; width:100%; height:100vh;">
		<div style="max-width: 576px; margin: 0 auto; padding-top: 30px; padding-bottom: 30px;">
			<div
				style="overflow: hidden; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
				<div style="background-color: #03438a; padding: 24px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
					<h1 style="color: #ffffff; font-size: 24px; font-weight: bold; margin: 0;">New Dental Appointment Booked</h1>
				</div>
				<div style="padding: 24px;">
					<p style="color: #374151; font-size: 18px; margin-bottom: 16px;">Dear Admin,</p>
					<p style="color: #374151; font-size: 16px; margin-bottom: 20px;">
						A new dental appointment has been successfully booked. Here are the details:
					</p>
					<div style="background-color: #f4f4f5; padding: 16px; border-radius: 8px;">
						<p><strong>Patient Name:</strong> {{ $patient->full_name }}</p>
						<p><strong>Date:</strong> {{ $formattedDate }}</p>
						<p><strong>Time:</strong> {{ $formattedTime }}</p>
						<p><strong>Service:</strong> {{ $service->name }}</p>
					</div>
					<p style="color: #374151; font-size: 16px; margin-top: 20px; margin-bottom: 20px;">
						Please ensure that everything is prepared for the appointment.
					</p>
					<p style="color: #374151; font-size: 16px; margin-bottom: 0;">
						Thank you for your attention to this matter.
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
