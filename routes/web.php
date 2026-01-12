<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\UserInvitationController;

Route::get('/', function () {
    return view('welcome');
});





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('invitation', [UserInvitationController::class, 'index'])
        ->name('invitation.index');
    Route::get('/dashboard/invitation/create', [UserInvitationController::class, 'create'])
        ->name('invitation.create');

    Route::post('/dashboard/invitation', [UserInvitationController::class, 'store'])
        ->name('invitation.store');

    Route::get('/dashboard/invitation/{invitation}/edit', [UserInvitationController::class, 'edit'])
        ->name('invitation.edit');

    Route::put('/dashboard/invitation/{invitation}', [UserInvitationController::class, 'update'])
        ->name('invitation.update');
});
Route::post('/rsvp/{invitation}', [RsvpController::class, 'store'])
    ->name('rsvp.store');
Route::get('/{slug}', [WeddingController::class, 'show']);
Route::get('/invitation/{invitation}/rsvps', [RsvpController::class, 'getRsvps'])->name('rsvp.list');
