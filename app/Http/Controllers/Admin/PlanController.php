<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\PlanCategory;
use App\Models\PlanFeature;
use App\Models\UserPlan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PlanController extends Controller
{
    /**
     * Display a listing of plans
     */
    public function index()
    {
        $plans = Plan::withCount('userPlans')
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan
     */
    public function create()
    {
        $categories = PlanCategory::orderBy('name')->get();
        return view('admin.plans.create', compact('categories'));
    }

    /**
     * Store a newly created plan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
            'min_return' => 'required|numeric|min:0',
            'max_return' => 'required|numeric|gte:min_return',
            'duration' => 'required|numeric|min:1',
            'duration_type' => 'required|in:days,weeks,months,years',
            'payout_interval' => 'required|in:daily,weekly,monthly',
            'return_type' => 'required|in:percentage,fixed_amount',
            'profit_calculation' => 'required|in:simple,compound',
            'allow_compounding' => 'sometimes|boolean',
            'compounding_percentage' => 'nullable|required_if:allow_compounding,true|numeric|min:1|max:100',
            'featured' => 'sometimes|boolean',
            'badge_text' => 'nullable|string|max:50',
            'color_scheme' => 'nullable|string|max:50',
            'active' => 'sometimes|boolean',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:plan_categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the plan
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->slug = Str::slug($request->name);
        $plan->description = $request->description;
        $plan->min_price = $request->min_price;
        $plan->max_price = $request->max_price;
        $plan->min_return = $request->min_return;
        $plan->max_return = $request->max_return;
        $plan->duration = $request->duration;
        $plan->duration_type = $request->duration_type;
        $plan->payout_interval = $request->payout_interval;
        $plan->return_type = $request->return_type;
        $plan->profit_calculation = $request->profit_calculation;
        $plan->allow_compounding = $request->has('allow_compounding');
        $plan->compounding_percentage = $request->compounding_percentage;
        $plan->featured = $request->has('featured');
        $plan->badge_text = $request->badge_text;
        $plan->color_scheme = $request->color_scheme;
        $plan->active = $request->has('active');
        $plan->sort_order = Plan::max('sort_order') + 1;

        // Save the plan
        $plan->save();

        // Sync categories
        if ($request->has('categories')) {
            $plan->categories()->sync($request->categories);
        }

        // Add features
        if ($request->has('features')) {
            foreach ($request->features as $feature) {
                $plan->planFeatures()->create([
                    'feature' => $feature['text'],
                    'included' => $feature['included'],
                    'icon' => $feature['icon'] ?? null,
                    'sort_order' => $loop->index ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Investment plan created successfully');
    }

    /**
     * Show the plan details
     */
    public function show(Plan $plan)
    {
        $plan->load('categories', 'planFeatures');
        $userPlans = UserPlan::where('plan_id', $plan->id)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.plans.show', compact('plan', 'userPlans'));
    }

    /**
     * Show the form for editing the plan
     */
    public function edit(Plan $plan)
    {
        $plan->load('categories', 'planFeatures');
        $categories = PlanCategory::orderBy('name')->get();

        return view('admin.plans.edit', compact('plan', 'categories'));
    }

    /**
     * Update the plan
     */
    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
            'min_return' => 'required|numeric|min:0',
            'max_return' => 'required|numeric|gte:min_return',
            'duration' => 'required|numeric|min:1',
            'duration_type' => 'required|in:days,weeks,months,years',
            'payout_interval' => 'required|in:daily,weekly,monthly',
            'return_type' => 'required|in:percentage,fixed_amount',
            'profit_calculation' => 'required|in:simple,compound',
            'allow_compounding' => 'sometimes|boolean',
            'compounding_percentage' => 'nullable|required_if:allow_compounding,true|numeric|min:1|max:100',
            'featured' => 'sometimes|boolean',
            'badge_text' => 'nullable|string|max:50',
            'color_scheme' => 'nullable|string|max:50',
            'active' => 'sometimes|boolean',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:plan_categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the plan
        $plan->name = $request->name;
        $plan->slug = Str::slug($request->name);
        $plan->description = $request->description;
        $plan->min_price = $request->min_price;
        $plan->max_price = $request->max_price;
        $plan->min_return = $request->min_return;
        $plan->max_return = $request->max_return;
        $plan->duration = $request->duration;
        $plan->duration_type = $request->duration_type;
        $plan->payout_interval = $request->payout_interval;
        $plan->return_type = $request->return_type;
        $plan->profit_calculation = $request->profit_calculation;
        $plan->allow_compounding = $request->has('allow_compounding');
        $plan->compounding_percentage = $request->compounding_percentage;
        $plan->featured = $request->has('featured');
        $plan->badge_text = $request->badge_text;
        $plan->color_scheme = $request->color_scheme;
        $plan->active = $request->has('active');

        // Save the plan
        $plan->save();

        // Sync categories
        $plan->categories()->sync($request->categories ?? []);

        // Handle features
        if ($request->has('features')) {
            // Delete old features and add new ones
            $plan->planFeatures()->delete();
            foreach ($request->features as $index => $feature) {
                if (!empty($feature['text'])) {
                    $plan->planFeatures()->create([
                        'feature' => $feature['text'],
                        'included' => isset($feature['included']) ? true : false,
                        'icon' => $feature['icon'] ?? null,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.plans.index')
            ->with('success', 'Investment plan updated successfully');
    }

    /**
     * Delete the plan (soft delete)
     */
    public function destroy(Plan $plan)
    {
        // Check if plan has active user plans
        $activeUserPlans = $plan->userPlans()->where('status', 'active')->count();
        
        if ($activeUserPlans > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete plan because it has active user investments');
        }

        // Detach categories
        $plan->categories()->detach();
        
        // Delete features
        $plan->planFeatures()->delete();
        
        // Soft delete the plan
        $plan->delete();

        return redirect()->route('admin.plans.index')
            ->with('success', 'Investment plan deleted successfully');
    }

    /**
     * Display all categories
     */
    public function categories()
    {
        $categories = PlanCategory::orderBy('sort_order')->get();
        return view('admin.plans.categories', compact('categories'));
    }

    /**
     * Store a new category
     */
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:plan_categories,name',
            'description' => 'nullable|string',
            'active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = new PlanCategory();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->active = $request->has('active');
        $category->sort_order = PlanCategory::max('sort_order') + 1;
        $category->save();

        return redirect()->back()
            ->with('success', 'Category created successfully');
    }

    /**
     * Update a category
     */
    public function updateCategory(Request $request, PlanCategory $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('plan_categories')->ignore($category)],
            'description' => 'nullable|string',
            'active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->active = $request->has('active');
        $category->save();

        return redirect()->back()
            ->with('success', 'Category updated successfully');
    }

    /**
     * Delete a category
     */
    public function destroyCategory(PlanCategory $category)
    {
        // Detach all plans from this category
        $category->plans()->detach();

        // Delete the category
        $category->delete();

        return redirect()->back()
            ->with('success', 'Category deleted successfully');
    }

    /**
     * Reorder plans
     */
    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plans' => 'required|array',
            'plans.*' => 'exists:plans,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        foreach ($request->plans as $index => $planId) {
            Plan::where('id', $planId)->update(['sort_order' => $index]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Plans reordered successfully',
        ]);
    }

    /**
     * View user plan details
     */
    public function userPlanDetails(UserPlan $userPlan)
    {
        $userPlan->load('user', 'plan', 'payouts');

        return view('admin.plans.user-plan-details', compact('userPlan'));
    }

    /**
     * Update user plan status
     */
    public function updateUserPlanStatus(Request $request, UserPlan $userPlan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldStatus = $userPlan->status;
        $userPlan->status = $request->status;

        // If activating the plan
        if ($request->status === 'active' && $oldStatus !== 'active') {
            $userPlan->activated_at = now();

            // Calculate expiration date based on plan duration
            $daysToAdd = $userPlan->plan->getDurationInDays();
            $userPlan->expires_at = now()->addDays($daysToAdd);
        }

        // Add notes if provided
        if ($request->has('notes')) {
            $userPlan->notes = $request->notes;
        }

        $userPlan->save();

        return redirect()->back()
            ->with('success', 'User plan status updated successfully');
    }
}
