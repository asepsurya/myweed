<?php

use App\Http\Controllers\GuestPhotoController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\YoutubeMusicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/midtrans/callback', [SubscriptionPlanController::class, 'callback'])->middleware('midtrans');
Route::get('/payment/success', [SubscriptionPlanController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [SubscriptionPlanController::class, 'failed'])->name('payment.failed');
Route::get('/payment/pending', [SubscriptionPlanController::class, 'pending'])->name('payment.pending');

Route::get('/music', [MusicController::class, 'apiIndex']);
Route::get('/music/{music}', [MusicController::class, 'apiShow']);
Route::get('/youtube-music', [YoutubeMusicController::class, 'apiIndex']);

// Guest Photo API Routes
// Note: api.php is already registered with the "api" prefix, so do NOT add "/api" here
// (otherwise the URL becomes /api/api/guest-photos).
Route::post('/guest-photos', [GuestPhotoController::class, 'store']);
Route::get('/guest-photos/{event_id}', [GuestPhotoController::class, 'show'])
    ->middleware('throttle:60,1');
Route::delete('/guest-photos/{id}', [GuestPhotoController::class, 'destroy']);
