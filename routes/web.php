<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserInvitationController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

Route::get('/home', [DashboardController::class, 'indexUser'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.user');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__ . '/auth.php';

Route::get('/templates/{slug}/{id}', [TempelateController::class, 'preview'])->name('template.preview');
Route::get('/demo/{slug}', [TempelateController::class, 'demo'])->name('template.demo');
Route::any('/invitation/live-preview', [TempelateController::class, 'liveUpdate'])->name('invitation.live-preview');
Route::post('/templates/{template}/like', [TempelateController::class, 'like'])->name('template.like');

Route::middleware(['auth'])->group(function () {

    Route::get('invitation', [UserInvitationController::class, 'index'])->middleware('role:admin')->name('invitation.index');
    Route::post('invitation/bulk-delete', [UserInvitationController::class, 'bulkDestroy'])->name('invitation.bulk-delete');
    Route::post('invitation/autosave', [UserInvitationController::class, 'autoSave'])->name('invitation.autosave');
    Route::get('invitation/create', [UserInvitationController::class, 'create'])->name('invitation.create');
    Route::post('invitation/quick-create', [UserInvitationController::class, 'quickCreate'])->name('invitation.quick-create');
    Route::get('invitation/{slug}', [UserInvitationController::class, 'detail'])->name('invitation.detail');
    Route::post('invitation', [UserInvitationController::class, 'store'])->name('invitation.store');
    Route::get('invitation/{invitation}/edit', [UserInvitationController::class, 'edit'])->name('invitation.edit');
    Route::put('invitation/{invitation}', [UserInvitationController::class, 'update'])->name('invitation.update');
    Route::delete('invitation/{invitation}', [UserInvitationController::class, 'destroy'])->name('invitation.destroy');
    Route::delete('/gallery/{id}', [UserInvitationController::class, 'destroyGallery'])->name('gallery.delete');
    Route::post('premium/upgrade', [UserInvitationController::class, 'upgradeToPremium'])->name('premium.upgrade');

    Route::post('/templates/import-code', [TempelateController::class, 'importCode'])->name('templates.import-code');
    Route::get('theme', [TempelateController::class, 'index'])->middleware('role:admin')->name('tempelate.index');
    Route::get('/templates/upload', [TempelateController::class, 'create']);
    Route::post('/templates/upload', [TempelateController::class, 'store']);
    Route::delete('/templates/{template}', [TempelateController::class, 'destroy'])->name('templates.destroy');

    Route::get('/templates/{slug}/{id}', [TempelateController::class, 'preview'])->name('template.preview');
    Route::put('/templates/{slug}/{id}', [TempelateController::class, 'previewUpdate'])->name('template.preview.update');

    Route::get('/template-assets/{slug}/{path}', function ($slug, $path) {
        $basePath = resource_path("views/templates/$slug");
        $filePath = realpath($basePath . '/' . ltrim($path, '/'));

        if (!$filePath || strpos($filePath, realpath($basePath)) !== 0 || !\Illuminate\Support\Facades\File::exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    })->where('path', '.*')->name('template.asset');

    Route::get('/musics', [MusicController::class, 'index'])->middleware('role:admin')->name('music.index');
    Route::post('/music/store', [MusicController::class, 'store'])->name('music.store');
    Route::delete('music/destroy/{id}', [MusicController::class, 'destroy'])->name('music.destroy');

    Route::get('/gifts', [GiftController::class, 'index'])->name('gift.index')->middleware('subscription');
    Route::post('/gifts', [GiftController::class, 'store'])->name('gift.store')->middleware('subscription');
    Route::delete('/gifts/{id}', [GiftController::class, 'destroy'])->name('gift.destroy')->middleware('subscription');

    Route::get('/users', [UserController::class, 'index'])->name('user.index')->middleware('role:admin');
    Route::get('/rsvps', [RsvpController::class, 'index'])->name('rsvp.index')->middleware('subscription');
    Route::delete('/rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvp.destroy')->middleware('subscription');

    Route::get('/subscription-plans', [SubscriptionPlanController::class, 'index'])->name('subscribe.page');
    Route::get('/subscription-plans/{planId}', [SubscriptionPlanController::class, 'subscribe'])->name('subscribe');
    Route::get('/payments', [SubscriptionPlanController::class, 'paymentIndex'])->name('payments.index');

});

Route::post('/rsvp/{invitation}', [RsvpController::class, 'store'])->name('rsvp.store');

Route::post('/invitation/{invitation}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');

Route::get('/invitation/{invitation}/rsvps', [RsvpController::class, 'getRsvps'])->name('rsvp.list');

Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/{slug}', [WeddingController::class, 'show'])->where('slug', '[A-Za-z0-9\-]+')->name('invitation.show');



Route::get('/payment/success', [SubscriptionPlanController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [SubscriptionPlanController::class, 'failed'])->name('payment.failed');
Route::get('/payment/pending', [SubscriptionPlanController::class, 'pending'])->name('payment.pending');
