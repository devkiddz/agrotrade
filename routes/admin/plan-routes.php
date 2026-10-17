<?php

use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;

// Admin Plan Management Routes
Route::middleware(['isadmin', '2fa'])->prefix('admin')->group(function () {
    // Plan management
    Route::prefix('plans')->name('admin.plans.')->group(function () {
        // List all plans
        Route::get('/', [PlanController::class, 'index'])->name('index');

        // Create new plan form
        Route::get('/create', [PlanController::class, 'create'])->name('create');

        // Store new plan
        Route::post('/', [PlanController::class, 'store'])->name('store');

        // Edit plan form
        Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');

        // Update plan
        Route::put('/{plan}', [PlanController::class, 'update'])->name('update');

        // Delete plan
        Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');

        // Toggle plan active status
        Route::post('/{plan}/toggle', [PlanController::class, 'toggleStatus'])->name('toggle');

        // Plan categories
        Route::get('/categories', [PlanController::class, 'categories'])->name('categories');

        // Create category
        Route::post('/categories', [PlanController::class, 'storeCategory'])->name('categories.store');

        // Edit category
        Route::put('/categories/{category}', [PlanController::class, 'updateCategory'])->name('categories.update');

        // Delete category
        Route::delete('/categories/{category}', [PlanController::class, 'destroyCategory'])->name('categories.destroy');

        // Manage features
        Route::post('/{plan}/features', [PlanController::class, 'storeFeature'])->name('features.store');
        Route::put('/{plan}/features/{feature}', [PlanController::class, 'updateFeature'])->name('features.update');
        Route::delete('/{plan}/features/{feature}', [PlanController::class, 'destroyFeature'])->name('features.destroy');
    });

    // User plans management
    Route::prefix('user-plans')->name('admin.user-plans.')->group(function () {
        // List all user plans
        Route::get('/', [PlanController::class, 'userPlans'])->name('index');

        // View user plan details
        Route::get('/{userPlan}', [PlanController::class, 'userPlanDetails'])->name('show');

        // Approve user plan
        Route::post('/{userPlan}/approve', [PlanController::class, 'approveUserPlan'])->name('approve');

        // Cancel user plan
        Route::post('/{userPlan}/cancel', [PlanController::class, 'cancelUserPlan'])->name('cancel');

        // Add manual payout
        Route::post('/{userPlan}/payout', [PlanController::class, 'addPayout'])->name('add-payout');
    });
});
