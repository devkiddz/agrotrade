<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Copytrading;
use App\Models\User_copytradings;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CopyTradingAdminController extends Controller
{
    /**
     * Display all expert traders
     */
    public function index()
    {
        $experts = Copytrading::withCount(['copiers', 'activeCopiers as active_copiers_count'])->get();
        $title = 'Manage Expert Traders';
        
        return view('admin.copy.index', compact('experts', 'title'));
    }

    /**
     * Show form to create new expert trader
     */
    public function create()
    {
        $title = 'Add New Expert Trader';
        return view('admin.copy.create', compact('title'));
    }

    /**
     * Store new expert trader
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'equity' => 'required|numeric|min:0',
            'total_profit' => 'required|numeric|min:0',
            'win_rate' => 'required|integer|min:0|max:100',
            'total_trades' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('photo');
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('copy-experts', $filename, 'public');
                $data['photo'] = $path;
            }

            Copytrading::create($data);

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader added successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add expert trader. Please try again.');
        }
    }

    /**
     * Show form to edit expert trader
     */
    public function edit($id)
    {
        $expert = Copytrading::findOrFail($id);
        $title = 'Edit Expert Trader';
        
        return view('admin.copy.edit', compact('expert', 'title'));
    }

    /**
     * Update expert trader
     */
    public function update(Request $request, $id)
    {
        $expert = Copytrading::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'equity' => 'required|numeric|min:0',
            'total_profit' => 'required|numeric|min:0',
            'win_rate' => 'required|integer|min:0|max:100',
            'total_trades' => 'required|integer|min:0',
            'price' => 'required|numeric|min:1',
            'tag' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->except('photo');
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo
                $currentPhoto = $expert->photo;
                if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                    Storage::disk('public')->delete($currentPhoto);
                }

                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('copy-experts', $filename, 'public');
                $data['photo'] = $path;
            }

            $expert->update($data);

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update expert trader. Please try again.');
        }
    }

    /**
     * Delete expert trader
     */
    public function destroy($id)
    {
        try {
            $expert = Copytrading::findOrFail($id);

            // Check if expert has active copiers
            $activeCopiers = User_copytradings::where('cptrading', $id)
                                             ->where('active', 'yes')
                                             ->count();

            if ($activeCopiers > 0) {
                return back()->with('error', 'Cannot delete expert trader with active copiers.');
            }

            // Delete photo if exists
            $currentPhoto = $expert->photo;
            if ($currentPhoto && Storage::disk('public')->exists($currentPhoto)) {
                Storage::disk('public')->delete($currentPhoto);
            }

            $expert->delete();

            return redirect()->route('admin.copy.index')
                           ->with('success', 'Expert trader deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete expert trader. Please try again.');
        }
    }

    /**
     * View active copy trades
     */
    public function activeTrades()
    {
        $copyTrades = User_copytradings::where('active', 'yes')
                                      ->with(['user', 'expert'])
                                      ->orderBy('created_at', 'desc')
                                      ->get();

        $title = 'Active Copy Trades';
        
        return view('admin.copy.active-trades', compact('copyTrades', 'title'));
    }

    /**
     * View copy trading statistics
     */
    public function statistics()
    {
        $stats = [
            'total_experts' => Copytrading::count(),
            'active_experts' => Copytrading::where('status', 'active')->count(),
            'total_copy_trades' => User_copytradings::count(),
            'active_copy_trades' => User_copytradings::where('active', 'yes')->count(),
            'total_invested' => User_copytradings::where('active', 'yes')->sum('price'),
            'total_profit' => User_copytradings::where('active', 'yes')->sum('total_profit'),
            'total_users_copying' => User_copytradings::where('active', 'yes')->distinct('user')->count(),
        ];

        $title = 'Copy Trading Statistics';
        
        return view('admin.copy.statistics', compact('stats', 'title'));
    }
}
