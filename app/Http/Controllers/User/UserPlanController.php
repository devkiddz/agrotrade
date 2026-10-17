<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanCategory;
use App\Models\UserPlan;
use App\Models\PlanPayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserPlanController extends Controller
{
    /**
     * Display available investment plans
     */
    public function index(Request $request)
    {
        $categoryId = $request->category ?? null;

        $categories = PlanCategory::active()
            ->withCount('plans')
            ->orderBy('sort_order')
            ->get();

        $plansQuery = Plan::active()
            ->with('planFeatures', 'categories')
            ->orderBy('featured', 'desc')
            ->orderBy('sort_order');

        if ($categoryId) {
            $plansQuery->byCategory($categoryId);
        }

        $plans = $plansQuery->get();

        return view('user.plan.index', compact('plans', 'categories', 'categoryId'));
    }

    /**
     * Show plan details
     */
    public function show(Plan $plan)
    {
        // Check if plan is active
        if (!$plan->active) {
            return redirect()->route('user.plans.index')
                ->with('error', 'The selected plan is no longer available.');
        }

        $plan->load('planFeatures', 'categories');
        $user = Auth::user();

        // Calculate expected returns for various investment amounts
        $minAmount = $plan->min_price;
        $maxAmount = $plan->max_price;
        $midAmount = ($minAmount + $maxAmount) / 2;

        $examples = [
            [
                'investment' => $minAmount,
                'return' => $plan->calculateExpectedReturn($minAmount),
                'profit' => $plan->calculateExpectedReturn($minAmount) - $minAmount
            ],
            [
                'investment' => $midAmount,
                'return' => $plan->calculateExpectedReturn($midAmount),
                'profit' => $plan->calculateExpectedReturn($midAmount) - $midAmount
            ],
            [
                'investment' => $maxAmount,
                'return' => $plan->calculateExpectedReturn($maxAmount),
                'profit' => $plan->calculateExpectedReturn($maxAmount) - $maxAmount
            ]
        ];

        return view('user.plan.show', compact('plan', 'user', 'examples'));
    }

    /**
     * Show user's active and past plans
     */
    public function myPlans(Request $request)
    {
        $status = $request->status ?? 'all';
        $userId = Auth::id();

        $plansQuery = UserPlan::where('user_id', $userId)
            ->with('plan')
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $plansQuery->where('status', $status);
        }

        $userPlans = $plansQuery->paginate(10);

        // Get statistics
        $stats = [
            'active' => UserPlan::where('user_id', $userId)
                ->where('status', 'active')
                ->count(),
            'completed' => UserPlan::where('user_id', $userId)
                ->where('status', 'completed')
                ->count(),
            'pending' => UserPlan::where('user_id', $userId)
                ->where('status', 'pending')
                ->count(),
            'total_invested' => UserPlan::where('user_id', $userId)
                ->sum('invested_amount'),
            'total_profit' => UserPlan::where('user_id', $userId)
                ->sum('total_profit'),
        ];

        return view('user.plan.my-plans', compact('userPlans', 'status', 'stats'));
    }

    /**
     * Show details for a specific user plan
     */
    public function userPlanDetails(UserPlan $userPlan)
    {
        // Check if the plan belongs to the authenticated user
        if ($userPlan->user_id !== Auth::id()) {
            return redirect()->route('user.plans.my')
                ->with('error', 'You do not have permission to view this plan.');
        }

        $userPlan->load('plan', 'payouts');

        // Get recent payouts
        $recentPayouts = $userPlan->payouts()
            ->where('status', 'processed')
            ->orderBy('processed_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.plan.details', compact('userPlan', 'recentPayouts'));
    }

    /**
     * Purchase an investment plan
     */
    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'compounding' => 'sometimes|boolean',
            'compounding_percentage' => 'nullable|required_if:compounding,true|numeric|min:1|max:100',
            'payment_method' => 'required|in:balance,bitcoin,ethereum,bank_transfer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the plan
        $plan = Plan::findOrFail($request->plan_id);

        // Check if plan is active
        if (!$plan->active) {
            return redirect()->route('user.plans.index')
                ->with('error', 'The selected plan is no longer available.');
        }

        // Validate investment amount
        $amount = $request->amount;
        if ($amount < $plan->min_price || $amount > $plan->max_price) {
            return redirect()->back()
                ->with('error', "Investment amount must be between {$plan->min_price} and {$plan->max_price}.")
                ->withInput();
        }

        $user = Auth::user();

        // Check if using account balance
        if ($request->payment_method === 'balance') {
            // Check if user has sufficient balance
            if ($user->account_bal < $amount) {
                return redirect()->back()
                    ->with('error', "Insufficient account balance. Your balance: {$user->currency}{$user->account_bal}")
                    ->withInput();
            }

            // Deduct from user's balance
            $user->account_bal -= $amount;
            $user->save();

            // Create the user plan with active status
            $userPlan = $this->createUserPlan($plan, $user, $amount, $request, 'active');

            return redirect()->route('user.plans.my')
                ->with('success', "Investment plan purchased successfully! Your plan is now active.");
        } else {
            // Create the user plan with pending status
            $userPlan = $this->createUserPlan($plan, $user, $amount, $request, 'pending');

            // Redirect to payment page
            return redirect()->route('user.plans.payment', $userPlan->id)
                ->with('success', "Please complete your payment to activate the plan.");
        }
    }

    /**
     * Show payment page for a pending plan
     */
    public function showPayment(UserPlan $userPlan)
    {
        // Check if the plan belongs to the authenticated user
        if ($userPlan->user_id !== Auth::id()) {
            return redirect()->route('user.plans.my')
                ->with('error', 'You do not have permission to view this payment page.');
        }

        // Check if the plan is pending
        if ($userPlan->status !== 'pending') {
            return redirect()->route('user.plans.details', $userPlan->id)
                ->with('error', 'This plan has already been processed.');
        }

        $userPlan->load('plan');

        return view('user.plan.payment', compact('userPlan'));
    }

    /**
     * Mark plan payment as completed (for external payments)
     */
    public function markPaymentCompleted(Request $request, UserPlan $userPlan)
    {
        // Check if the plan belongs to the authenticated user
        if ($userPlan->user_id !== Auth::id()) {
            return redirect()->route('user.plans.my')
                ->with('error', 'You do not have permission to update this plan.');
        }

        // Check if the plan is pending
        if ($userPlan->status !== 'pending') {
            return redirect()->route('user.plans.details', $userPlan->id)
                ->with('error', 'This plan has already been processed.');
        }

        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string|max:255',
            'payment_proof' => 'nullable|file|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update payment reference
        $userPlan->payment_reference = $request->transaction_id;

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment_proofs', $filename, 'public');
            $userPlan->notes = 'Payment proof uploaded: ' . $path;
        }

        $userPlan->save();

        return redirect()->route('user.plans.my')
            ->with('success', 'Payment marked as completed. Your plan will be activated after verification.');
    }

    /**
     * Cancel a pending plan
     */
    public function cancelPlan(UserPlan $userPlan)
    {
        // Check if the plan belongs to the authenticated user
        if ($userPlan->user_id !== Auth::id()) {
            return redirect()->route('user.plans.my')
                ->with('error', 'You do not have permission to cancel this plan.');
        }

        // Check if the plan is pending
        if ($userPlan->status !== 'pending') {
            return redirect()->route('user.plans.details', $userPlan->id)
                ->with('error', 'Only pending plans can be cancelled.');
        }

        // Update status to cancelled
        $userPlan->status = 'cancelled';
        $userPlan->save();

        return redirect()->route('user.plans.my')
            ->with('success', 'Investment plan cancelled successfully.');
    }

    /**
     * Toggle compounding for an active plan
     */
    public function toggleCompounding(Request $request, UserPlan $userPlan)
    {
        // Check if the plan belongs to the authenticated user
        if ($userPlan->user_id !== Auth::id()) {
            return redirect()->route('user.plans.my')
                ->with('error', 'You do not have permission to modify this plan.');
        }

        // Check if the plan is active
        if ($userPlan->status !== 'active') {
            return redirect()->route('user.plans.details', $userPlan->id)
                ->with('error', 'Only active plans can be modified.');
        }

        // Check if the plan allows compounding
        if (!$userPlan->plan->allow_compounding) {
            return redirect()->route('user.plans.details', $userPlan->id)
                ->with('error', 'This plan does not allow compounding.');
        }

        $validator = Validator::make($request->all(), [
            'compounding' => 'required|boolean',
            'compounding_percentage' => 'nullable|required_if:compounding,true|numeric|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update compounding settings
        $userPlan->compounding_enabled = $request->compounding;
        $userPlan->compounding_percentage = $request->compounding_percentage;
        $userPlan->save();

        return redirect()->route('user.plans.details', $userPlan->id)
            ->with('success', 'Compounding settings updated successfully.');
    }

    /**
     * Helper method to create a user plan
     */
    private function createUserPlan(Plan $plan, $user, $amount, Request $request, $status = 'pending')
    {
        // Calculate expected return
        $expectedReturn = $plan->calculateExpectedReturn($amount);

        // Create the user plan
        $userPlan = new UserPlan();
        $userPlan->user_id = $user->id;
        $userPlan->plan_id = $plan->id;
        $userPlan->invested_amount = $amount;
        $userPlan->current_value = $amount;
        $userPlan->roi_percentage = ($plan->min_return + $plan->max_return) / 2;
        $userPlan->expected_return = $expectedReturn;
        $userPlan->status = $status;
        $userPlan->payment_method = $request->payment_method;

        // Set compounding if applicable
        if ($plan->allow_compounding && $request->has('compounding') && $request->compounding) {
            $userPlan->compounding_enabled = true;
            $userPlan->compounding_percentage = $request->compounding_percentage;
        }

        // Set dates if the plan is active
        if ($status === 'active') {
            $userPlan->activated_at = Carbon::now();

            // Calculate expiration date based on plan duration
            $daysToAdd = $plan->getDurationInDays();
            $userPlan->expires_at = Carbon::now()->addDays($daysToAdd);
        }

        $userPlan->save();

        return $userPlan;
    }
}
