<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Footer;
use App\Models\Contact;
use App\Models\Patient;
use App\Models\Category;
use App\Models\Appointment;
use App\Models\Reservation;
use App\Models\SocialMedia;
use App\Models\Transaction;
use Spatie\Browsershot\Browsershot;
use App\Models\DailyPatientCapacity;
use Illuminate\Support\Facades\File;
use App\Notifications\NewReservation;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\UserController;
use App\Notifications\NoShowAppointment;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\FooterController;
use App\Notifications\AppointmentReminder;
use App\Notifications\ApprovedReservation;
use App\Notifications\DeclinedReservation;
use App\Notifications\ReminderAppointment;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Notifications\CompletedAppointment;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UnitTypeController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DailyPatientCapacityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Test notif
Route::get('/notification', function () {
    $user = User::find(1);
    $reservation = Reservation::find(7);
    $appointment = Appointment::find(12);
    //* Reservation
    // return (new ApprovedReservation($reservation))
    // return (new DeclinedReservation($reservation))
    // return (new NewReservation($reservation))

    //* Appointment
    // return (new CompletedAppointment($appointment))
    // return (new NoShowAppointment($appointment))
    return (new ReminderAppointment($appointment))
        ->toMail($user);
});


// Home Route
Route::get('/', function () {
    $contacts = Contact::all();
    $footer = Footer::first();
    $socialMedias = SocialMedia::all();
    $socials = [];

    foreach ($socialMedias as $item) {
        $platform = strtolower($item->platform);
        $socials[$platform] = [
            'url' => $item->url,
            'status' => $item->status,
        ];
    }
    return view('welcome', compact('contacts', 'footer', 'socials'));
});

// User View Services
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    // User Profile Page - Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('dashboard', [ServiceController::class, 'display'])->name('user.dashboard');

    Route::get('/capacity/{dateId}', [DailyPatientCapacityController::class, 'getCapacity'])->name('capacity.check');

    Route::get('reservation/{service}/create', [ReservationController::class, 'create'])->name('user.reserve');
    Route::post('reservation/{service}/store', [ReservationController::class, 'store'])->name('user.reserve.store');

    Route::get('user-reservations/list', [ReservationController::class, 'userReservationList'])->name('user.reservation.list');
    Route::get('user-appointments/list', [AppointmentController::class, 'userAppointmentList'])->name('user.appointment.list');
    Route::get('user-service-histories/list', [AppointmentController::class, 'myServiceHistories'])->name('user.service-histories.list');
});


// Profile Update and Delete Routes
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
    Route::delete('/avatar/remove', [ProfileController::class, 'removeAvatar'])->name('avatar.remove');

    Route::post('api/fetch-city', [RegisteredUserController::class, 'fetchCity']);
    Route::post('api/fetch-barangay', [RegisteredUserController::class, 'fetchBarangay']);
    Route::post('/get-cities/{provinceCode}', [ProfileController::class, 'getCities'])->name('profile.getCities');
    Route::post('/get-barangays/{cityCode}', [ProfileController::class, 'getBarangays'])->name('profile.getBarangays');
});

// Admin CRUD Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Providers CRUD
    Route::get('admin/providers/create', [ProviderController::class, 'create'])->name('providers.create');
    Route::post('admin/providers', [ProviderController::class, 'store'])->name('providers.store');
    Route::get('admin/providers/{provider}/edit', [ProviderController::class, 'edit'])->name('providers.edit');
    Route::put('admin/providers/{provider}', [ProviderController::class, 'update'])->name('providers.update');

    // Patients CRUD
    Route::get('admin/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('admin/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('admin/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('admin/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');


    // Accounts (User) CRUD
    Route::get('admin/accounts/create', [UserController::class, 'create'])->name('admin.accounts.create');
    Route::post('admin/accounts', [UserController::class, 'store'])->name('admin.accounts.store');
    Route::get('admin/accounts/{account}/edit', [UserController::class, 'edit'])->name('admin.accounts.edit');
    Route::put('admin/accounts/{account}', [UserController::class, 'update'])->name('admin.accounts.update');

    // Social Media CRUD
    Route::get('admin/social-media/create', [SocialMediaController::class, 'create'])->name('social-media.create');
    Route::post('admin/social-media', [SocialMediaController::class, 'store'])->name('social-media.store');
    Route::get('admin/social-media/{social_media}/edit', [SocialMediaController::class, 'edit'])->name('social-media.edit');
    Route::put('admin/social-media/{social_media}', [SocialMediaController::class, 'update'])->name('social-media.update');


    // Activity Logs
    Route::get('admin/activity-logs', [ActivityLogController::class, 'displayLogs'])->name('display.activity.logs');

    // API to add patients address
    Route::post('admin/patients/api/fetch-city', [RegisteredUserController::class, 'fetchCity']);
    Route::post('admin/patients/api/fetch-barangay', [RegisteredUserController::class, 'fetchBarangay']);

    // API to add providers address
    Route::post('admin/providers/api/fetch-city', [RegisteredUserController::class, 'fetchCity']);
    Route::post('admin/providers/api/fetch-barangay', [RegisteredUserController::class, 'fetchBarangay']);

    // API to add staff/admin
    Route::post('admin/accounts/api/fetch-city', [RegisteredUserController::class, 'fetchCity']);
    Route::post('admin/accounts/api/fetch-barangay', [RegisteredUserController::class, 'fetchBarangay']);
});

// Admin and Staff Read-only Routes
Route::middleware(['auth', 'role:admin|staff'])->group(function () {
    // Dashboard
    Route::get('admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/get-appointment-trends', [AdminController::class, 'getTrends']);
    Route::get('/get-sales-trends', [AdminController::class, 'getSalesTrends']);

    // Profile
    Route::get('admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');

    // Providers Read-only
    Route::get('admin/providers', [ProviderController::class, 'index'])->name('providers.index');

    // Services CRUD
    Route::get('admin/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('admin/services', [ServiceController::class, 'store'])->name('services.store');

    // Services Read-only
    Route::get('admin/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('admin/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::get('admin/service/search', [ServiceController::class, 'searchService'])->name('services.search'); //

    // Patients Read-only
    Route::get('admin/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('admin/patients/record/{patient}', [MedicalHistoryController::class, 'show'])->name('show.patient.record');
    Route::post('admin/patients/download-patient-list', [PatientController::class, 'downloadPatientList'])->name('download.patient.list');
    Route::post('admin/paients/download/patient-histories/{patient}/', [MedicalHistoryController::class, 'downloadServiceHistories'])->name('download.patient.service.histories');

    // Accounts Read-only
    Route::get('admin/accounts', [UserController::class, 'index'])->name('accounts.index');

    // Products and Categories (Admin and Staff)
    Route::post('admin/product/download-product-list', [ProductController::class, 'downloadProductList'])->name('download.product.list');
    Route::get('admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('admin/products/{product}', [ProductController::class, 'update'])->name('products.update');


    Route::resource('admin/categories', CategoryController::class);

    // Product Transaction
    Route::resource('admin/transactions', TransactionController::class);
    Route::post('/check-stock', [TransactionController::class, 'checkStock'])->name('check.stock');
    Route::post('admin/download/transaction-records', [TransactionController::class, 'downloadTransactionRecords'])->name('download.transaction.records');

    // Unit Types
    Route::resource('admin/unit-types', UnitTypeController::class);

    // Prescriptions Read-only
    Route::get('admin/prescriptions', [PrescriptionController::class, 'index'])->name('admin.prescriptions.index');
    Route::get('admin/download-pdf/{prescription}', [PrintController::class, 'downloadPDF'])->name('admin.prescriptions.downloadPDF');
    Route::get('admin/preview-pdf/{prescription}', [PrintController::class, 'previewPDF'])->name('admin.prescriptions.previewPDF');


    // Daily Patient Capacity
    Route::resource('admin/daily-patient-capacity', DailyPatientCapacityController::class);

    // Reservations
    Route::get('admin/reservations', [ReservationController::class, 'reservationList'])->name('admin.reservation.list');
    Route::patch('admin/reservation/update', [ReservationController::class, 'update'])->name('admin.reservation-status.update');

    // Appointments
    Route::get('admin/appointments', [AppointmentController::class, 'indexAdmin'])->name('admin.appointments.view');
    Route::get('admin/appointment-details/{appointment}/view', [AppointmentController::class, 'viewAppointmentDetailsAdmin'])->name('admin.appointment-details.view');

    // Settings
    Route::get('admin/settings', [AppSettingController::class, 'index'])->name('admin.settings');


    // Contacts and Footer
    Route::patch('admin/contacts/unset/{contact}', [ContactController::class, 'unset'])->name('unset');
    Route::resource('admin/contacts', ContactController::class);
    Route::patch('admin/footer/{footer}', [FooterController::class, 'update'])->name('footer.update');
});

// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('superadmin/profile', [ProfileController::class, 'edit'])->name('superadmin.profile.edit');

    // Appointments
    Route::get('superadmin/appointments', [AppointmentController::class, 'index'])->name('superadmin.appointments.view');
    Route::get('superadmin/appointment-details/{appointment}/view', [AppointmentController::class, 'viewAppointmentDetails'])->name('superadmin.appointment-details.view');
    Route::patch('superadmin/appointment/edit', [AppointmentController::class, 'update'])->name('superadmin.update.appointment');

    // Prescriptions
    Route::get('superadmin/prescriptions/{patient}/create', [PrescriptionController::class, 'create'])->name('create.prescription');
    Route::resource('superadmin/prescriptions', PrescriptionController::class)->names('superadmin.prescriptions');

    // TODO:
    Route::get('superadmin/download-pdf/{prescription}', [PrintController::class, 'downloadPDF'])->name('superadmin.prescriptions.downloadPDF');
    Route::get('superadmin/preview-pdf/{prescription}', [PrintController::class, 'previewPDF'])->name('superadmin.prescriptions.previewPDF');

    // Patients
    Route::get('superadmin/patient/search', [PatientController::class, 'search'])->name('superadmin.search.patient');
    Route::resource('superadmin/patients', PatientController::class)->names([
        'index' => 'superadmin.patients.index',
        'create' => 'superadmin.patients.create',
        'store' => 'superadmin.patients.store',
        'show' => 'superadmin.patients.show',
        'edit' => 'superadmin.patients.edit',
        'update' => 'superadmin.patients.update',
        'destroy' => 'superadmin.patients.destroy',
    ]);

    // Medical History
    Route::post('superadmin/add-medical-history', [MedicalHistoryController::class, 'store'])->name('add.medical.history');
    Route::put('superadmin/edit-medical-history/', [MedicalHistoryController::class, 'update'])->name('update.medical.history');

    // Patient Record
    Route::get('superadmin/patients/record/{patient}', [MedicalHistoryController::class, 'show'])->name('superadmin.show.patient.record');
});


Route::get('/test-notif', function () {
    // Get reservations with an 'approved' status for tomorrow
    $approvedReservations = Reservation::whereDate('date', Carbon::tomorrow())
        ->where('status', 'approved')
        ->get();

    // Ensure that you only notify unique users
    $notifiedUsers = [];

    foreach ($approvedReservations as $reservation) {
        $user = $reservation->patient->user ?? null;

        if ($user && !in_array($user->id, $notifiedUsers)) {
            // Send the reminder to the user
            Notification::send($user, new ReminderAppointment($reservation));

            // Add the user ID to the notified list
            $notifiedUsers[] = $user->id;
        }
    }

    return "Notifications sent to users with approved reservations for tomorrow.";
});


Route::get('/inventory', function () {
    $transactions = Transaction::all();

    $path = public_path('images/DocClinicx.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $html = view('reports_template.transactions_list', ['imageSrc' => $src, 'transactions' => $transactions])->render();
    $currentDateTime = Carbon::now()->format('d-m-Y');

    $pdfPath = public_path('Filarca - Rabena_Transaction_Records_' . $currentDateTime . '.pdf');

    Browsershot::html($html)->margins(15.4, 15.4, 15.4, 15.4)->showBackground()->save($pdfPath);

    return response()->download($pdfPath)->deleteFileAfterSend(true);

    // Step 7: Return the generated PDF as a response to be viewed inline in the browser
    return response()->file($pdfPath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="example.pdf"',
    ]);


    // return view('reports_template.transactions_list');
});

// service histories
Route::get('history', function () {
    $patient = Patient::find(5);

    $serviceHistories =
        Appointment::join('reservations', 'appointments.reservation_id', '=', 'reservations.id')
            ->where('reservations.patient_id', $patient->id)
            ->where('appointments.status', 'completed')
            ->select('appointments.*') // Select appointment columns
            ->get();

    $path = public_path('images/FILARCA.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $html = view('reports_template.patient_service_histories', [
        'imageSrc' => $src,
        'serviceHistories' => $serviceHistories,
        'patientName' => $patient->user->full_name
    ])->render();

    $patientNameExt = $patient->user->first_name . '_' . $patient->user->last_name;
    $pdfPath = public_path('FR_' . $patientNameExt . '_service_histories.pdf');

    Browsershot::html($html)
        ->margins(15.4, 15.4, 15.4, 15.4)
        ->showBackground()
        ->save($pdfPath);

    // Step 7: Return the generated PDF as a response to be viewed inline in the browser
    return response()->file($pdfPath, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="example.pdf"',
    ]);

    return response()->download($pdfPath)->deleteFileAfterSend(true);
});

require __DIR__ . '/auth.php';
