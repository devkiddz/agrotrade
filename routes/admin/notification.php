<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Routes with admin. prefix
Route::middleware(['isadmin', '2fa'])->prefix('admin/notifications')->name('admin.')->group(function () {
    Route::get('/', [NotificationController::class, 'adminIndex'])->name('notifications');
    Route::get('/show/{id}', [NotificationController::class, 'adminShow'])->name('notifications.show');
    Route::get('/send', [NotificationController::class, 'showSendMessageForm'])->name('notifications.send');
    Route::post('/send', [NotificationController::class, 'sendAdminMessageToUser'])->name('notifications.send.post');
    Route::delete('/delete', [NotificationController::class, 'webDeleteNotification'])->name('notifications.delete');
});

// Routes without prefix - these match the URLs in topmenu.blade.php
Route::middleware(['isadmin', '2fa'])->group(function () {
    Route::get('/admin/notifications/count', [NotificationController::class, 'getUnreadCount']);
    Route::post('/admin/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::post('/admin/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);
    Route::post('/admin/notifications/create-test', [NotificationController::class, 'createTestNotification']);
});
