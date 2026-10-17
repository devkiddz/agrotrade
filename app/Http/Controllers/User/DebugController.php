<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tp_Transaction;
use Illuminate\Support\Facades\Log;

class DebugController extends Controller
{
    public function debugTradingHistory()
    {
        // Log user and authentication info
        $user = Auth::user();
        $isAuthenticated = Auth::check();

        Log::info('Debug Trading History', [
            'authenticated' => $isAuthenticated,
            'user_id' => $user ? $user->id : 'not logged in',
            'user_name' => $user ? $user->name : 'not logged in'
        ]);

        if ($isAuthenticated) {
            // Get transactions
            $transactions = Tp_Transaction::where('user', $user->id)
                ->whereIn('type', ['Sell','Buy','WIN','LOSE'])
                ->orderByDesc('id')
                ->limit(5)
                ->get();

            Log::info('Trading History Transactions', [
                'count' => $transactions->count(),
                'transactions' => $transactions->toArray()
            ]);

            // Return same view as tradinghistory
            return view("user.thistory")
                ->with(array(
                    't_history' => Tp_Transaction::where('user', $user->id)
                        ->whereIn('type', ['Sell','Buy','WIN','LOSE'])
                        ->orderByDesc('id')
                        ->paginate(15),
                    'title' => 'Trading History Debug',
                    'debug_info' => true,
                ));
        }

        return redirect('/login')->with('error', 'You need to be logged in to see trading history.');
    }
}
