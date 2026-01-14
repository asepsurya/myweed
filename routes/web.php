<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\UserInvitationController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('invitation', [UserInvitationController::class, 'index'])
        ->name('invitation.index');
    Route::get('nvitation/create', [UserInvitationController::class, 'create'])
        ->name('invitation.create');

    Route::post('invitation', [UserInvitationController::class, 'store'])
        ->name('invitation.store');

    Route::get('invitation/{invitation}/edit', [UserInvitationController::class, 'edit'])
        ->name('invitation.edit');

    Route::put('invitation/{invitation}', [UserInvitationController::class, 'update'])
        ->name('invitation.update');

           Route::delete('/gallery/{id}', [UserInvitationController::class, 'destroyGallery'])
        ->name('gallery.delete');

    Route::get('theme', [TempelateController::class, 'index'])->name('tempelate.index');
    Route::get('/templates/upload', [TempelateController::class, 'create']);
    Route::post('/templates/upload', [TempelateController::class, 'store']);
    Route::delete('/templates/{template}', [TempelateController::class, 'destroy'])->name('templates.destroy');

    Route::post('theme/music/store', [MusicController::class, 'store'])->name('music.store');
    Route::delete('theme/music/destroy/{id}', [MusicController::class, 'destroy'])->name('music.destroy');

});
Route::post('/rsvp/{invitation}', [RsvpController::class, 'store'])
    ->name('rsvp.store');
Route::get('/{slug}', [WeddingController::class, 'show']);
Route::get('/invitation/{invitation}/rsvps', [RsvpController::class, 'getRsvps'])->name('rsvp.list');
