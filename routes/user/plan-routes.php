<?php

use App\Http\Controllers\User\UserPlanController;
use Illuminate\Support\Facades\Route;

// Investment Plan Routes
Route::middleware(['auth:sanctum', 'verified', 'complete.kyc'])->prefix('plans')->name('user.plans.')->group(function () {
    // Browse plans
    Route::get('/', [UserPlanController::class, 'index'])->name('index');

    // Show plan details
    Route::get('/{plan}', [UserPlanController::class, 'show'])->name('show');

    // My active plans
    Route::get('/my-plans', [UserPlanController::class, 'myPlans'])->name('my-plans');

    // Plan details page for user's own plan
    Route::get('/details/{userPlan}', [UserPlanController::class, 'details'])->name('details');

    // Investment page
    Route::get('/{plan}/invest', [UserPlanController::class, 'invest'])->name('invest');

    // Process investment request
    Route::post('/{plan}/invest', [UserPlanController::class, 'processInvestment'])->name('process-investment');

    // Payment page
    Route::get('/payment/{userPlan}', [UserPlanController::class, 'payment'])->name('payment');

    // Process payment
    Route::post('/payment/{userPlan}', [UserPlanController::class, 'processPayment'])->name('process-payment');

    // View contract
    Route::get('/contract/{userPlan}', [UserPlanController::class, 'contract'])->name('contract');

    // Cancel pending plan
    Route::post('/cancel/{userPlan}', [UserPlanController::class, 'cancelPlan'])->name('cancel');
});
