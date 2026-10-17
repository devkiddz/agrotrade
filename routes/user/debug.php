<?php

// Add the debug route
Route::get('debug-trading-history', [\App\Http\Controllers\User\DebugController::class, 'debugTradingHistory'])->name('debug.tradinghistory');

?>
