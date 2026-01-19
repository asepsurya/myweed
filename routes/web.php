<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\UserInvitationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified','role:admin'])
    ->name('dashboard');

Route::get('/home', [DashboardController::class, 'indexUser'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.user');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('invitation', [UserInvitationController::class, 'index'])->middleware('role:admin')->name('invitation.index');
    Route::get('invitation/create', [UserInvitationController::class, 'create'])->name('invitation.create');
    Route::get('invitation/{slug}', [UserInvitationController::class, 'detail'])->name('invitation.detail');
    Route::post('invitation', [UserInvitationController::class, 'store'])->name('invitation.store');
    Route::get('invitation/{invitation}/edit', [UserInvitationController::class, 'edit'])->name('invitation.edit');
    Route::put('invitation/{invitation}', [UserInvitationController::class, 'update'])->name('invitation.update');
    Route::delete('/gallery/{id}', [UserInvitationController::class, 'destroyGallery'])->name('gallery.delete');

    Route::get('theme', [TempelateController::class, 'index'])->middleware('role:admin')->name('tempelate.index');
    Route::get('/templates/upload', [TempelateController::class, 'create']);
    Route::post('/templates/upload', [TempelateController::class, 'store']);
    Route::delete('/templates/{template}', [TempelateController::class, 'destroy'])->name('templates.destroy');

    Route::get('/musics', [MusicController::class, 'index'])->middleware('role:admin')->name('music.index');
    Route::post('/music/store', [MusicController::class, 'store'])->name('music.store');
    Route::delete('music/destroy/{id}', [MusicController::class, 'destroy'])->name('music.destroy');

    Route::get('/gifts', [GiftController::class, 'index'])->name('gift.index');
    Route::post('/gifts', [GiftController::class, 'store'])->name('gift.store');
    Route::delete('/gifts/{id}', [GiftController::class, 'destroy'])->name('gift.destroy');

});

Route::get('/rsvps', [RsvpController::class, 'index'])->name('rsvp.index');
Route::delete('/rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvp.destroy');
Route::post('/rsvp/{invitation}', [RsvpController::class, 'store'])->name('rsvp.store');
Route::get('/invitation/{invitation}/rsvps', [RsvpController::class, 'getRsvps'])->name('rsvp.list');
Route::get('/{slug}', [WeddingController::class, 'show'])->where('slug', '[A-Za-z0-9\-]+')->name('invitation.show');



