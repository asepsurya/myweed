<?php

use App\Http\Controllers\AiChatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\TemplateCreatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInvitationController;
use App\Http\Controllers\WeedingPlanController;
use App\Http\Controllers\WeddingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard');

Route::get('/dashboard/check-update', [DashboardController::class, 'checkUpdate'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard.check-update');

Route::get('/home', [DashboardController::class, 'indexUser'])
    ->middleware(['auth'])
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
    Route::get('/tema', [DashboardController::class, 'temaIndex'])->name('tema.index');
    Route::get('theme', [TempelateController::class, 'index'])->middleware('role:admin')->name('tempelate.index');
    Route::get('/templates/upload', [TempelateController::class, 'create']);
    Route::post('/templates/upload', [TempelateController::class, 'store']);
    Route::delete('/templates/{template}', [TempelateController::class, 'destroy'])->name('templates.destroy');

    Route::middleware(['role:admin'])->prefix('template-creator')->group(function () {
        Route::get('/', [App\Http\Controllers\TemplateCreatorController::class, 'index'])->name('template-creator.index');
        Route::get('/create', [App\Http\Controllers\TemplateCreatorController::class, 'create'])->name('template-creator.create');
        Route::post('/generate', [App\Http\Controllers\TemplateCreatorController::class, 'generateWithAI'])->name('template-creator.generate');
        Route::get('/generate', function () {
            return redirect()->route('template-creator.index');
        });
        Route::post('/improve-prompt', [App\Http\Controllers\TemplateCreatorController::class, 'improvePrompt'])->name('template-creator.improve-prompt');
        Route::post('/', [App\Http\Controllers\TemplateCreatorController::class, 'store'])->name('template-creator.store');
        Route::get('/{template}/edit', [App\Http\Controllers\TemplateCreatorController::class, 'edit'])->name('template-creator.edit');
        Route::put('/{template}', [App\Http\Controllers\TemplateCreatorController::class, 'update'])->name('template-creator.update');
        Route::delete('/{template}', [App\Http\Controllers\TemplateCreatorController::class, 'destroy'])->name('template-creator.destroy');
        Route::get('/{template}/preview', [App\Http\Controllers\TemplateCreatorController::class, 'preview'])->name('template-creator.preview');
        Route::post('/preview-code', [App\Http\Controllers\TemplateCreatorController::class, 'previewCode'])->name('template-creator.preview-code');
    });

    Route::get('/categories', [CategoryController::class, 'index'])->middleware('role:admin')->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:admin')->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin')->name('categories.destroy');

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
    Route::get('/music/create', [MusicController::class, 'create'])->middleware('role:admin')->name('music.create');
    Route::post('/music/store', [MusicController::class, 'store'])->middleware('role:admin')->name('music.store');
    Route::get('/music/{music}/edit', [MusicController::class, 'edit'])->middleware('role:admin')->name('music.edit');
    Route::put('/music/{music}', [MusicController::class, 'update'])->middleware('role:admin')->name('music.update');
    Route::delete('music/destroy/{id}', [MusicController::class, 'destroy'])->middleware('role:admin')->name('music.destroy');
    Route::post('/music/sync-local', [MusicController::class, 'syncLocal'])->middleware('role:admin')->name('music.sync-local');

    Route::get('/gifts', [GiftController::class, 'index'])->name('gift.index')->middleware('subscription');
    Route::post('/gifts', [GiftController::class, 'store'])->name('gift.store')->middleware('subscription');
    Route::delete('/gifts/{id}', [GiftController::class, 'destroy'])->name('gift.destroy')->middleware('subscription');

    Route::get('/users', [UserController::class, 'index'])->name('user.index')->middleware('role:admin');
    Route::get('/rsvps', [RsvpController::class, 'index'])->name('rsvp.index')->middleware('subscription');
    Route::delete('/rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvp.destroy')->middleware('subscription');

    Route::get('/subscription-plans', [SubscriptionPlanController::class, 'index'])->name('subscribe.page');
    Route::get('/subscription-plans/{planId}', [SubscriptionPlanController::class, 'subscribe'])->name('subscribe');
    Route::get('/payments', [SubscriptionPlanController::class, 'paymentIndex'])->name('payments.index');

    Route::get('/weeding-plan', [WeedingPlanController::class, 'index'])->name('weeding-plan.index');
    Route::get('/weeding-plan/create', [WeedingPlanController::class, 'create'])->name('weeding-plan.create');
    Route::post('/weeding-plan', [WeedingPlanController::class, 'store'])->name('weeding-plan.store');
    Route::get('/weeding-plan/{weedingPlan}/edit', [WeedingPlanController::class, 'edit'])->name('weeding-plan.edit');
    Route::put('/weeding-plan/{weedingPlan}', [WeedingPlanController::class, 'update'])->name('weeding-plan.update');
    Route::delete('/weeding-plan/{weedingPlan}', [WeedingPlanController::class, 'destroy'])->name('weeding-plan.destroy');
    Route::post('/weeding-plan/{weedingPlan}/toggle', [WeedingPlanController::class, 'toggleStatus'])->name('weeding-plan.toggle');

});

Route::post('/rsvp/{invitation}', [RsvpController::class, 'store'])->name('rsvp.store');

Route::post('/invitation/{invitation}/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');

Route::get('/invitation/{invitation}/rsvps', [RsvpController::class, 'getRsvps'])->name('rsvp.list');

Route::get('/auth/google', [GoogleController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/cara-pemesanan', [LandingController::class, 'caraPemesanan'])->name('pages.cara-pemesanan');
Route::get('/faq', [LandingController::class, 'faq'])->name('pages.faq');
Route::get('/syarat-ketentuan', [LandingController::class, 'syaratKetentuan'])->name('pages.syarat-ketentuan');
Route::get('/cari-tema', [LandingController::class, 'cariTema'])->name('pages.cari-tema');
Route::get('/fitur', [LandingController::class, 'fitur'])->name('pages.fitur');
Route::get('/harga', [LandingController::class, 'harga'])->name('pages.harga');
Route::get('/bantuan', [LandingController::class, 'bantuan'])->name('pages.bantuan');

Route::get('/kebijakan-privasi', [LandingController::class, 'kebijakanPrivasi'])->name('pages.kebijakan-privasi');

Route::get('/{slug}', [WeddingController::class, 'show'])->where('slug', '[A-Za-z0-9\-]+')->name('invitation.show');



Route::get('/payment/success', [SubscriptionPlanController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [SubscriptionPlanController::class, 'failed'])->name('payment.failed');
Route::get('/payment/pending', [SubscriptionPlanController::class, 'pending'])->name('payment.pending');
