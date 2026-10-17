<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User_plans;
use App\Models\User;
use App\Models\Tp_Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TradesExport;

class TradesController extends Controller
{
    /**
     * Display a listing of user trades
     */
    public function index(Request $request)
    {
        $query = User_plans::with('user');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('active', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('asset')) {
            $query->where('assets', 'like', "%{$request->asset}%");
        }

        // Get paginated trades
        $trades = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate statistics
        $stats = [
            'total' => User_plans::count(),
            'active' => User_plans::where('active', 'yes')->count(),
            'expired' => User_plans::where('active', 'expired')->count(),
            'total_volume' => User_plans::sum('amount')
        ];

        $title = 'User Trades Management';

        return view('admin.trades.index', compact('trades', 'stats', 'title'));
    }

    /**
     * Show the form for editing the specified trade
     */
    public function edit($id)
    {
        try {
            $trade = User_plans::with('user')->findOrFail($id);
            \Log::info('Trade data found for edit:', ['trade' => $trade->toArray()]);

            // If it's an AJAX request, return JSON for modal use
            if (request()->ajax()) {
                return response()->json($trade);
            }

            // Otherwise return the edit view
            $title = 'Edit Trade';
            return view('admin.trades.edit', compact('trade', 'title'));
        } catch (\Exception $e) {
            \Log::error('Error finding trade for edit:', ['id' => $id, 'error' => $e->getMessage()]);

            if (request()->ajax()) {
                return response()->json(['error' => 'Trade not found'], 404);
            }

            return redirect()->route('admin.trades.index')->with('error', 'Trade not found');
        }
    }

    /**
     * Update the specified trade in storage
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'assets' => 'required|string|max:255',
            'type' => 'required|in:Buy,Sell',
            'amount' => 'required|numeric|min:0',
            'leverage' => 'nullable|numeric|min:1',
            'profit_earned' => 'nullable|numeric',
            'active' => 'required|in:yes,expired',
            'expire_date' => 'nullable|date'
        ]);

        try {
            $trade = User_plans::findOrFail($id);

            $trade->update([
                'assets' => $request->assets,
                'type' => $request->type,
                'amount' => $request->amount,
                'leverage' => $request->leverage,
                'profit_earned' => $request->profit_earned,
                'active' => $request->active,
                'expire_date' => $request->expire_date
            ]);

            return redirect()->route('admin.trades.index')
                           ->with('success', 'Trade updated successfully!');

        } catch (\Exception $e) {
            Log::error('Error updating trade: ' . $e->getMessage(), [
                'trade_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                           ->with('error', 'Failed to update trade. Please try again.');
        }
    }

    /**
     * Add profit to user ROI and trade
     */
    public function addProfit(Request $request, $id)
    {
        $request->validate([
            'profit_amount' => 'required|numeric',
            'note' => 'nullable|string|max:500'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $trade = User_plans::findOrFail($id);
                $user = $trade->user;

                if (!$user) {
                    throw new \Exception('User not found for this trade');
                }

                $profitAmount = $request->profit_amount;

                // Update trade profit
                $currentProfit = $trade->profit_earned ?? 0;
                $trade->update([
                    'profit_earned' => $currentProfit + $profitAmount
                ]);

                // Update user ROI
                $currentRoi = $user->roi ?? 0;
                $user->update([
                    'roi' => $currentRoi + $profitAmount
                ]);

                // Create transaction record
                Tp_Transaction::create([
                    'user' => $user->id,
                    'plan' => $trade->id,
                    'amount' => $profitAmount,
                    'type' => $profitAmount >= 0 ? 'Profit' : 'Loss',
                    'status' => 'Processed',
                    'txn_id' => 'ADMIN_PROFIT_' . time() . '_' . $trade->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Log the action
                Log::info('Admin added profit to trade', [
                    'admin_id' => auth()->id(),
                    'trade_id' => $id,
                    'user_id' => $user->id,
                    'profit_amount' => $profitAmount,
                    'note' => $request->note,
                    'new_trade_profit' => $trade->profit_earned,
                    'new_user_roi' => $user->roi
                ]);
            });

            return redirect()->route('admin.trades.index')
                           ->with('success', 'Profit added successfully! User ROI has been updated.');

        } catch (\Exception $e) {
            Log::error('Error adding profit to trade: ' . $e->getMessage(), [
                'trade_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                           ->with('error', 'Failed to add profit. Please try again.');
        }
    }

    /**
     * Remove the specified trade from storage
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $trade = User_plans::findOrFail($id);

                // Log the deletion
                Log::info('Admin deleted trade', [
                    'admin_id' => auth()->id(),
                    'trade_id' => $id,
                    'user_id' => $trade->user_id,
                    'trade_data' => $trade->toArray()
                ]);

                // Delete related transactions
                Tp_Transaction::where('plan', $id)->delete();

                // Delete the trade
                $trade->delete();
            });

            return redirect()->route('admin.trades.index')
                           ->with('success', 'Trade deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting trade: ' . $e->getMessage(), [
                'trade_id' => $id
            ]);

            return redirect()->back()
                           ->with('error', 'Failed to delete trade. Please try again.');
        }
    }

    /**
     * Export trades data
     */
    public function export(Request $request)
    {
        try {
            $format = $request->get('format', 'csv');
            $filename = 'trades_export_' . date('Y-m-d_H-i-s');

            // Apply same filters as index method
            $query = User_plans::with('user');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('active', $request->status);
            }

            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('asset')) {
                $query->where('assets', 'like', "%{$request->asset}%");
            }

            $trades = $query->orderBy('created_at', 'desc')->get();

            if ($format === 'excel') {
                return Excel::download(new TradesExport($trades), $filename . '.xlsx');
            } else {
                return Excel::download(new TradesExport($trades), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
            }

        } catch (\Exception $e) {
            Log::error('Error exporting trades: ' . $e->getMessage());

            return redirect()->back()
                           ->with('error', 'Failed to export trades. Please try again.');
        }
    }

    /**
     * Get trade statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_trades' => User_plans::count(),
                'active_trades' => User_plans::where('active', 'yes')->count(),
                'completed_trades' => User_plans::where('active', 'expired')->count(),
                'total_volume' => User_plans::sum('amount'),
                'total_profit' => User_plans::sum('profit_earned'),
                'avg_trade_size' => User_plans::avg('amount'),
                'recent_trades' => User_plans::with('user')
                                            ->orderBy('created_at', 'desc')
                                            ->limit(5)
                                            ->get(),
                'top_traders' => User::select('users.*')
                                    ->selectRaw('COUNT(user_plans.id) as trade_count')
                                    ->selectRaw('SUM(user_plans.amount) as total_volume')
                                    ->selectRaw('SUM(user_plans.profit_earned) as total_profit')
                                    ->join('user_plans', 'users.id', '=', 'user_plans.user_id')
                                    ->groupBy('users.id')
                                    ->orderBy('total_volume', 'desc')
                                    ->limit(10)
                                    ->get()
            ];

            return response()->json($stats);

        } catch (\Exception $e) {
            Log::error('Error getting trade stats: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch statistics'], 500);
        }
    }

    /**
     * Bulk actions on trades
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,expire',
            'trade_ids' => 'required|array',
            'trade_ids.*' => 'exists:user_plans,id'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $tradeIds = $request->trade_ids;
                $action = $request->action;

                switch ($action) {
                    case 'delete':
                        User_plans::whereIn('id', $tradeIds)->delete();
                        Tp_Transaction::whereIn('plan', $tradeIds)->delete();
                        break;

                    case 'activate':
                        User_plans::whereIn('id', $tradeIds)->update(['active' => 'yes']);
                        break;

                    case 'expire':
                        User_plans::whereIn('id', $tradeIds)->update(['active' => 'expired']);
                        break;
                }

                Log::info('Admin performed bulk action on trades', [
                    'admin_id' => auth()->id(),
                    'action' => $action,
                    'trade_ids' => $tradeIds,
                    'count' => count($tradeIds)
                ]);
            });

            return redirect()->route('admin.trades.index')
                           ->with('success', 'Bulk action completed successfully!');

        } catch (\Exception $e) {
            Log::error('Error performing bulk action: ' . $e->getMessage(), [
                'action' => $request->action,
                'trade_ids' => $request->trade_ids
            ]);

            return redirect()->back()
                           ->with('error', 'Failed to perform bulk action. Please try again.');
        }
    }
}
