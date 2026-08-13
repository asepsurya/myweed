<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BudgetCategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EnvSettingController;
use App\Http\Controllers\FinancialDashboardController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MayarController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\SavingsAutomationController;
use App\Http\Controllers\SavingsContributionController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\TempelateController;
use App\Http\Controllers\TemplateCreatorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserInvitationController;
use App\Http\Controllers\VendorPaymentController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\WeedingPlanController;
use Illuminate\Support\Facades\File;

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

require __DIR__.'/auth.php';

Route::get('/templates/{slug}/{id}', [TempelateController::class, 'preview'])->name('template.preview');
Route::get('/demo/{slug}', [TempelateController::class, 'demo'])->name('template.demo');
Route::get('/preview/{slug}/{id}', function ($slug, $id) {
    return view('pages.template-preview', compact('slug', 'id'));
})->name('template.frame');
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
    Route::delete('invitation/{invitation}/gallery/{id}', [UserInvitationController::class, 'destroyGallery'])->name('gallery.delete');
    Route::post('invitation/{invitation}/gallery', [UserInvitationController::class, 'uploadGallery'])->name('gallery.upload');
    Route::post('invitation/{invitation}/cover', [UserInvitationController::class, 'uploadCover'])->name('cover.upload');
    Route::post('invitation/{invitation}/groom-photo', [UserInvitationController::class, 'uploadGroomPhoto'])->name('groom-photo.upload');
    Route::post('invitation/{invitation}/bride-photo', [UserInvitationController::class, 'uploadBridePhoto'])->name('bride-photo.upload');
    Route::post('premium/upgrade', [UserInvitationController::class, 'upgradeToPremium'])->name('premium.upgrade');

    Route::post('invitation/{invitation}/invite-partner', [UserInvitationController::class, 'invitePartner'])->name('invitation.invite-partner');
    Route::get('partner/accept/{token}', [UserInvitationController::class, 'acceptPartner'])->name('partner.accept');
    Route::post('invitation/{invitation}/accept-partner', [UserInvitationController::class, 'acceptPartnerDirect'])->name('partner.accept-direct');
    Route::post('invitation/{invitation}/remove-partner', [UserInvitationController::class, 'removePartner'])->name('invitation.remove-partner');

    Route::post('/templates/import-code', [TempelateController::class, 'importCode'])->name('templates.import-code');
    Route::get('/tema', [DashboardController::class, 'temaIndex'])->name('tema.index');
    Route::get('theme', [TempelateController::class, 'index'])->middleware('role:admin')->name('tempelate.index');
    Route::get('/templates/upload', [TempelateController::class, 'create']);
    Route::post('/templates/upload', [TempelateController::class, 'store']);
    Route::delete('/templates/{template}', [TempelateController::class, 'destroy'])->name('templates.destroy');

    Route::middleware(['role:admin'])->prefix('template-creator')->group(function () {
        Route::get('/', [TemplateCreatorController::class, 'index'])->name('template-creator.index');
        Route::get('/create', [TemplateCreatorController::class, 'create'])->name('template-creator.create');
        Route::post('/generate', [TemplateCreatorController::class, 'generateWithAI'])->name('template-creator.generate');
        Route::get('/generate', function () {
            return redirect()->route('template-creator.index');
        });
        Route::post('/improve-prompt', [TemplateCreatorController::class, 'improvePrompt'])->name('template-creator.improve-prompt');
        Route::post('/', [TemplateCreatorController::class, 'store'])->name('template-creator.store');
        Route::get('/{template}/edit', [TemplateCreatorController::class, 'edit'])->name('template-creator.edit');
        Route::put('/{template}', [TemplateCreatorController::class, 'update'])->name('template-creator.update');
        Route::delete('/{template}', [TemplateCreatorController::class, 'destroy'])->name('template-creator.destroy');
        Route::get('/{template}/preview', [TemplateCreatorController::class, 'preview'])->name('template-creator.preview');
        Route::post('/preview-code', [TemplateCreatorController::class, 'previewCode'])->name('template-creator.preview-code');
    });

    Route::get('/categories', [CategoryController::class, 'index'])->middleware('role:admin')->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->middleware('role:admin')->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin')->name('categories.destroy');

    Route::get('/templates/{slug}/{id}', [TempelateController::class, 'preview'])->name('template.preview');
    Route::put('/templates/{slug}/{id}', [TempelateController::class, 'previewUpdate'])->name('template.preview.update');

    Route::get('/template-assets/{slug}/{path}', function ($slug, $path) {
        $basePath = resource_path("views/templates/$slug");
        $filePath = realpath($basePath.'/'.ltrim($path, '/'));

        if (! $filePath || strpos($filePath, realpath($basePath)) !== 0 || ! File::exists($filePath)) {
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
    Route::post('/subscription/cancel', [SubscriptionPlanController::class, 'cancel'])->name('subscription.cancel')->middleware('auth');
    Route::get('/payments', [SubscriptionPlanController::class, 'paymentIndex'])->name('payments.index');
    Route::post('/coupons/validate', [SubscriptionPlanController::class, 'validateCoupon'])->name('coupons.validate');
    Route::post('/mayar/create-payment-link', [MayarController::class, 'createPaymentLink'])->middleware('auth')->name('mayar.create-payment-link');

    Route::middleware('role:admin')->prefix('admin/settings')->name('settings.')->group(function () {
        Route::get('/env', [EnvSettingController::class, 'index'])->name('env');
        Route::post('/env', [EnvSettingController::class, 'update'])->name('env.update');
    });

    Route::middleware('role:admin')->prefix('admin/subscription-plans')->name('subscription-plans.')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'adminIndex'])->name('index');
        Route::get('/create', [SubscriptionPlanController::class, 'create'])->name('create');
        Route::post('/', [SubscriptionPlanController::class, 'store'])->name('store');
        Route::get('/{subscriptionPlan}/edit', [SubscriptionPlanController::class, 'edit'])->name('edit');
        Route::put('/{subscriptionPlan}', [SubscriptionPlanController::class, 'update'])->name('update');
        Route::delete('/{subscriptionPlan}', [SubscriptionPlanController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('role:admin')->prefix('admin/subscriptions')->name('admin.subscriptions.')->group(function () {
        Route::get('/', [SubscriptionPlanController::class, 'userIndex'])->name('index');
        Route::post('/{user}/plan', [SubscriptionPlanController::class, 'updateUserPlan'])->name('update-plan');
        Route::post('/{user}/cancel', [SubscriptionPlanController::class, 'cancelUserSubscription'])->name('cancel');
    });

    Route::middleware('role:admin')->prefix('admin/promotions')->name('promotions.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/create', [PromotionController::class, 'create'])->name('create');
        Route::post('/', [PromotionController::class, 'store'])->name('store');
        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('edit');
        Route::put('/{promotion}', [PromotionController::class, 'update'])->name('update');
        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('role:admin')->prefix('admin/coupons')->name('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::put('/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy');
    });

    Route::get('/weeding-plan', [WeedingPlanController::class, 'index'])->name('weeding-plan.index');
    Route::get('/weeding-plan/create', [WeedingPlanController::class, 'create'])->name('weeding-plan.create');
    Route::post('/weeding-plan', [WeedingPlanController::class, 'store'])->name('weeding-plan.store');
    Route::get('/weeding-plan/{weedingPlan}/edit', [WeedingPlanController::class, 'edit'])->name('weeding-plan.edit');
    Route::put('/weeding-plan/{weedingPlan}', [WeedingPlanController::class, 'update'])->name('weeding-plan.update');
    Route::delete('/weeding-plan/{weedingPlan}', [WeedingPlanController::class, 'destroy'])->name('weeding-plan.destroy');
    Route::post('/weeding-plan/{weedingPlan}/toggle', [WeedingPlanController::class, 'toggleStatus'])->name('weeding-plan.toggle');

    /* ================== FINANCIAL MODULES ================== */
    Route::middleware(['auth', 'subscription'])->group(function () {
        /* ---- Budget Management ---- */
        Route::get('/budget', [BudgetController::class, 'dashboard'])->name('budget.dashboard');
        Route::put('/budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');

        Route::get('/budget/categories', [BudgetCategoryController::class, 'index'])->name('budget.category.index');
        Route::post('/budget/categories', [BudgetCategoryController::class, 'store'])->name('budget.category.store');
        Route::get('/budget/categories/{category}/edit', [BudgetCategoryController::class, 'edit'])->name('budget.category.edit');
        Route::put('/budget/categories/{category}', [BudgetCategoryController::class, 'update'])->name('budget.category.update');
        Route::delete('/budget/categories/{category}', [BudgetCategoryController::class, 'destroy'])->name('budget.category.destroy');

        Route::get('/budget/expenses', [BudgetExpenseController::class, 'index'])->name('budget.expense.index');
        Route::get('/budget/expenses/create', [BudgetExpenseController::class, 'create'])->name('budget.expense.create');
        Route::post('/budget/expenses', [BudgetExpenseController::class, 'store'])->name('budget.expense.store');
        Route::get('/budget/expenses/{expense}/edit', [BudgetExpenseController::class, 'edit'])->name('budget.expense.edit');
        Route::put('/budget/expenses/{expense}', [BudgetExpenseController::class, 'update'])->name('budget.expense.update');
        Route::delete('/budget/expenses/{expense}', [BudgetExpenseController::class, 'destroy'])->name('budget.expense.destroy');

        Route::get('/budget/payments', [VendorPaymentController::class, 'index'])->name('budget.payment.index');
        Route::post('/budget/payments', [VendorPaymentController::class, 'store'])->name('budget.payment.store');
        Route::put('/budget/payments/{payment}/pay', [VendorPaymentController::class, 'markPaid'])->name('budget.payment.mark-paid');
        Route::put('/budget/payments/{payment}', [VendorPaymentController::class, 'update'])->name('budget.payment.update');
        Route::delete('/budget/payments/{payment}', [VendorPaymentController::class, 'destroy'])->name('budget.payment.destroy');

        /* ---- Joint Savings Tracker ---- */
        Route::get('/savings', [SavingsController::class, 'dashboard'])->name('savings.dashboard');
        Route::get('/savings/projection', [SavingsController::class, 'projection'])->name('savings.projection');

        Route::get('/savings/goals', [SavingsGoalController::class, 'index'])->name('savings.goal.index');
        Route::get('/savings/goals/create', [SavingsGoalController::class, 'create'])->name('savings.goal.create');
        Route::post('/savings/goals', [SavingsGoalController::class, 'store'])->name('savings.goal.store');
        Route::get('/savings/goals/{goal}/edit', [SavingsGoalController::class, 'edit'])->name('savings.goal.edit');
        Route::put('/savings/goals/{goal}', [SavingsGoalController::class, 'update'])->name('savings.goal.update');
        Route::delete('/savings/goals/{goal}', [SavingsGoalController::class, 'destroy'])->name('savings.goal.destroy');
        Route::post('/savings/goals/{goal}/toggle', [SavingsGoalController::class, 'toggleActive'])->name('savings.goal.toggle');

        Route::get('/savings/contributions', [SavingsContributionController::class, 'index'])->name('savings.contribution.index');
        Route::post('/savings/contributions', [SavingsContributionController::class, 'store'])->name('savings.contribution.store');
        Route::get('/savings/contributions/{contribution}/edit', [SavingsContributionController::class, 'edit'])->name('savings.contribution.edit');
        Route::put('/savings/contributions/{contribution}', [SavingsContributionController::class, 'update'])->name('savings.contribution.update');
        Route::delete('/savings/contributions/{contribution}', [SavingsContributionController::class, 'destroy'])->name('savings.contribution.destroy');

        Route::get('/savings/automation', [SavingsAutomationController::class, 'index'])->name('savings.automation.index');
        Route::post('/savings/automation', [SavingsAutomationController::class, 'updateRule'])->name('savings.automation.update');

        /* ---- Unified Financial Overview ---- */
        Route::get('/financial-overview', [FinancialDashboardController::class, 'index'])->name('financial-overview.index');

        Route::get('/documentation', [DocumentationController::class, 'index'])->name('documentation.index');
    });

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

Route::post('/mayar/webhook', [MayarController::class, 'webhook'])->name('mayar.webhook');
