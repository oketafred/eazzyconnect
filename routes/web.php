<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactImportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsBundleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\SmsReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return to_route('login');
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/groups', [GroupController::class, 'index'])
        ->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])
        ->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])
        ->name('groups.store');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])
        ->name('groups.edit');
    Route::get('/groups/{group}/show', [GroupController::class, 'show'])
        ->name('groups.show');
    Route::put('/groups/{group}', [GroupController::class, 'update'])
        ->name('groups.update');

    Route::get('/groups/{group}/contacts/import', [ContactImportController::class, 'index'])
        ->name('contact-import.index');
    Route::post('/groups/{group}/contacts/import', [ContactImportController::class, 'store'])
        ->name('contact-import.store');

    Route::get('/contact/download-template', function () {
        $path = public_path('ContactsTemplate.csv');

        return response()->download($path, 'ContactsTemplate', [
            'Content-Type' => 'text/csv',
        ]);
    })->name('contact.import');

    Route::post('/contact/{group}', [ContactController::class, 'store'])
        ->name('contact.store');

    Route::get('/sms_bundle', [SmsBundleController::class, 'index'])
        ->name('sms-bundle.index');

    Route::post('/sms_bundle/payment', [SmsBundleController::class, 'store'])
        ->name('sms-bundle.payment');

    Route::post('/verify-transaction/{transaction_id}', [SmsBundleController::class, 'verifyTransaction'])
        ->name('sms-bundle.payment.verify');

    Route::post('cancel-transaction/{transaction_reference}', [SmsBundleController::class, 'cancelTransaction'])
        ->name('bundle-sms.cancel-transaction');


    Route::get('/sms/create', [SmsController::class, 'create'])
        ->name('sms.create');
    Route::post('/sms', [SmsController::class, 'store'])
        ->name('sms.store');

    Route::get('sms_report', [SmsReportController::class, 'index'])
        ->name('sms-report.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
