<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HospitalManagerController;
use App\Http\Controllers\RegistrationStaffController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\InpatientPatientController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\InpatientMedicalRecordController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout'); 
Route::get('/register', function () {
    return view('user.createuser');
})->name('register');
Route::post('/register', [UserController::class, 'register'])->name('user.register')->middleware('throttle:5,1');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'showDashboard'])->name('doctors.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/registrationstaff/dashboard', [UserController::class, 'staffsDashboard'])->name('registrationstaff.dashboard');
    Route::get('/nurse/dashboard', [UserController::class, 'nursesDashboard'])->name('nurse.dashboard');
    Route::get('/manager/dashboard', [HospitalManagerController::class, 'showDashboard'])->name('manager.dashboard');
});
Route::get('/doctor/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        Log::warning('Unauthenticated access to dashboard');
        return redirect()->route('login');
    }

    Log::info('User accessed dashboard', [
        'user_id' => $user->id,
        'access_level' => $user->access_level,
    ]);

    return view('doctors.menu', ['access_level' => $user->access_level]);
})->middleware(['auth', 'role:Doctor'])->name('doctor.dashboard');

Route::get('/doctor/menu', [App\Http\Controllers\MedicalRecordController::class, 'showDashboard'])
    ->middleware(['auth'])
    ->name('doctors.menu');

// Appointment Routes (Accessible by Admin, Registration Staff)
Route::middleware(['auth'])->group(function () {
   
    Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});

// Admission Routes (Accessible by Admin, Registration Staff)
Route::middleware(['auth'])->group(function () {
    Route::resource('admissions', AdmissionController::class);
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
    Route::get('/admissions/create', [AdmissionController::class, 'create'])->name('admissions.create');
    Route::post('/admissions', [AdmissionController::class, 'store'])->name('admissions.store');
    Route::get('/admissions/rooms', [AdmissionController::class, 'getAvailableRooms'])->name('admissions.getAvailableRooms');
    Route::put('/admissions/{admission}', [AdmissionController::class, 'update'])->name('admissions.update');
});

// Other Routes (unchanged)
Route::middleware(['auth'])->group(function () {
    Route::resource('doctors', DoctorController::class);
    Route::resource('hospital_managers', HospitalManagerController::class);
    Route::resource('registrationstaff', RegistrationStaffController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('medical_records', MedicalRecordController::class);
    Route::resource('pharmacists', PharmacistController::class);

    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::get('/medical-records/create/{appointment}', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/patients/{id}/details', [PatientController::class, 'showDetails'])->name('patients.showDetails');
    Route::get('patients/{patient}/print', [PatientController::class, 'printDetails'])->name('patients.printDetails');

    Route::get('/admissions/{admission}/medical-records/create', [InpatientMedicalRecordController::class, 'createForInpatient'])->name('medical_records.createForInpatient');
    Route::post('/admissions/{admission}/medical-records', [InpatientMedicalRecordController::class, 'storeForInpatient'])->name('medical_records.storeForInpatient');
    Route::get('/medical_records/inpatients/{admission}', [InpatientMedicalRecordController::class, 'showDetailsInpatient'])->name('medical_records.showDetailsInpatient');
    Route::get('/inpatient/medical-records', [InpatientMedicalRecordController::class, 'indexInpatient'])->name('medical_records.indexInpatient');
    Route::get('/medical_records/print_inpatient/{admission}', [InpatientMedicalRecordController::class, 'printDetailsInpatient'])->name('medical_records.printDetailsInpatient');
    Route::get('/inpatient/medical-records/print', [InpatientMedicalRecordController::class, 'printInpatient'])->name('medical_records.printInpatient');

    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/select-payment-method/{id}', [BillingController::class, 'selectPaymentMethod'])->name('billing.selectPaymentMethod');
    Route::post('/billing/select-payment-method/{id}', [BillingController::class, 'processSelectedPayment'])->name('billing.processSelectedPayment');
    Route::post('/billing/{admission}/processPayment', [BillingController::class, 'processPayment'])->name('billing.processPayment');

    Route::get('/inpatient/patients', [InpatientPatientController::class, 'index'])->name('inpatient.patients.index');
    Route::get('/inpatient/patients/create', [InpatientPatientController::class, 'create'])->name('inpatient.patients.create');
    Route::post('/inpatient/patients', [InpatientPatientController::class, 'store'])->name('inpatient.patients.store');
    Route::get('/inpatient/patients/{patient}/edit', [InpatientPatientController::class, 'edit'])->name('inpatient.patients.edit');
    Route::put('/inpatient/patients/{patient}', [InpatientPatientController::class, 'update'])->name('inpatient.patients.update');

    Route::get('/manager/print-appointments', [HospitalManagerController::class, 'printAppointments'])->name('manager.print_appointments');
    Route::get('/manager/print-medical-records', [HospitalManagerController::class, 'printMedicalRecords'])->name('manager.print_medical_records');
});