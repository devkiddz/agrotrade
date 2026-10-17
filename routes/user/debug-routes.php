<?php
// Add a debug route for testing
Route::get('debug-history', [App\Http\Controllers\User\HistoryDebugController::class, 'debug'])->name('debug.history');
