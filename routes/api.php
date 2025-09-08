<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\MembershipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Публичные API маршруты с базовым ограничением (60 запросов в минуту)
Route::middleware(['throttle:api'])->group(function () {
    // Информационные endpoints
    Route::get('/events', [EventController::class, 'apiIndex']);
    Route::get('/events/{event}', [EventController::class, 'apiShow']);
    Route::get('/news', [NewsController::class, 'apiIndex']);
    Route::get('/news/{news}', [NewsController::class, 'apiShow']);
    Route::get('/branches', [BranchController::class, 'apiIndex']);
    Route::get('/branches/{branch}', [BranchController::class, 'apiShow']);
    Route::get('/publications', [PublicationController::class, 'apiIndex']);
    Route::get('/publications/{publication}', [PublicationController::class, 'apiShow']);
    Route::get('/conferences', [ConferenceController::class, 'apiIndex']);
    Route::get('/conferences/{conference}', [ConferenceController::class, 'apiShow']);
});

// Строгие ограничения для операций записи (10 запросов в минуту)
Route::middleware(['throttle:api-write'])->group(function () {
    // Регистрация на конференции
    Route::post('/conferences/{conference}/register', [ConferenceController::class, 'apiRegister']);
    
    // Оплата членства
    Route::post('/membership/payment', [MembershipController::class, 'apiPayment']);
    Route::post('/membership/qr', [MembershipController::class, 'apiGenerateQR']);
});

// Очень строгие ограничения для чувствительных операций (5 запросов в минуту)
Route::middleware(['throttle:api-sensitive'])->group(function () {
    // Загрузка файлов
    Route::post('/publications/{publication}/upload', [PublicationController::class, 'apiUpload']);
    
    // Создание новых записей (только для авторизованных пользователей)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events', [EventController::class, 'apiStore']);
        Route::put('/events/{event}', [EventController::class, 'apiUpdate']);
        Route::delete('/events/{event}', [EventController::class, 'apiDestroy']);
    });
});

// Авторизованные пользователи (30 запросов в минуту)
Route::middleware(['auth:sanctum', 'throttle:api-auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Пользовательский кабинет API
    Route::prefix('cabinet')->group(function () {
        Route::get('/profile', function (Request $request) {
            return response()->json($request->user());
        });
        Route::put('/profile', function (Request $request) {
            // Логика обновления профиля
            return response()->json(['message' => 'Profile updated successfully']);
        });
        Route::get('/events', function (Request $request) {
            // Логика получения мероприятий пользователя
            return response()->json(['events' => []]);
        });
        Route::get('/certificates', function (Request $request) {
            // Логика получения сертификатов пользователя
            return response()->json(['certificates' => []]);
        });
    });
});

// Административные операции (очень строгие ограничения - 3 запроса в минуту)
Route::middleware(['auth:sanctum', 'throttle:api-admin'])->group(function () {
    // Только для администраторов
    Route::middleware('can:admin-access')->group(function () {
        Route::post('/admin/events', [EventController::class, 'apiAdminStore']);
        Route::put('/admin/events/{event}', [EventController::class, 'apiAdminUpdate']);
        Route::delete('/admin/events/{event}', [EventController::class, 'apiAdminDestroy']);
        
        Route::post('/admin/news', [NewsController::class, 'apiAdminStore']);
        Route::put('/admin/news/{news}', [NewsController::class, 'apiAdminUpdate']);
        Route::delete('/admin/news/{news}', [NewsController::class, 'apiAdminDestroy']);
    });
});