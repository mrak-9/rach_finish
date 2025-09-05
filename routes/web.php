<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\UserCabinetController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages routes (temporary placeholders)
Route::get('/about', function () { return view('static.about'); })->name('about');
Route::get('/media', function () { return view('static.media'); })->name('media');
Route::get('/cooperation', function () { return view('static.cooperation'); })->name('cooperation');
Route::get('/offer', function () { return view('static.offer'); })->name('offer');
Route::get('/branches', [BranchController::class, 'index'])->name('branches');
Route::get('/branches/{branch}', [BranchController::class, 'show'])->name('branches.show');
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/conferences', [ConferenceController::class, 'index'])->name('conferences');
Route::get('/conferences/{conference}', [ConferenceController::class, 'show'])->name('conferences.show');
Route::post('/conferences/{conference}/register', [ConferenceController::class, 'register'])->name('conferences.register');
Route::get('/publications', [PublicationController::class, 'index'])->name('publications');
Route::get('/publications/{publication}', [PublicationController::class, 'show'])->name('publications.show');
Route::get('/publications/{publication}/download/{file}', [PublicationController::class, 'download'])->name('publications.download');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/partners', [PartnerController::class, 'index'])->name('partners');
Route::get('/partners/{partner}', [PartnerController::class, 'show'])->name('partners.show');
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::post('/membership/payment', [MembershipController::class, 'payment'])->name('membership.payment');
Route::post('/membership/qr', [MembershipController::class, 'generateQR'])->name('membership.qr');

// Auth routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User Cabinet routes
    Route::prefix('cabinet')->name('cabinet.')->group(function () {
        Route::get('/profile', [UserCabinetController::class, 'profile'])->name('profile');
        Route::put('/profile', [UserCabinetController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [UserCabinetController::class, 'updatePassword'])->name('password.update');
        Route::get('/events', [UserCabinetController::class, 'events'])->name('events');
        Route::get('/certificates', [UserCabinetController::class, 'certificates'])->name('certificates');
        Route::get('/membership', [UserCabinetController::class, 'membership'])->name('membership');
        Route::post('/thesis/{participation}', [UserCabinetController::class, 'uploadThesis'])->name('thesis.upload');
    });
});

require __DIR__.'/auth.php';
