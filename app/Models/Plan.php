<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'min_price',
        'max_price',
        'min_return',
        'max_return',
        'bonus_percentage',
        'duration',
        'duration_type',
        'payout_interval',
        'return_type',
        'profit_calculation',
        'allow_compounding',
        'compounding_percentage',
        'featured',
        'badge_text',
        'color_scheme',
        'active',
        'sort_order',
        'features',
    ];

    protected $casts = [
        'min_price' => 'decimal:8',
        'max_price' => 'decimal:8',
        'min_return' => 'decimal:2',
        'max_return' => 'decimal:2',
        'bonus_percentage' => 'decimal:2',
        'allow_compounding' => 'boolean',
        'featured' => 'boolean',
        'active' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the user plans associated with this plan
     */
    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class);
    }

    /**
     * Get the features for this plan
     */
    public function planFeatures(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    /**
     * Get the categories for this plan
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PlanCategory::class, 'plan_plan_category');
    }

    /**
     * Calculate the duration in days
     */
    public function getDurationInDays(): int
    {
        $multiplier = match ($this->duration_type) {
            'days' => 1,
            'weeks' => 7,
            'months' => 30,
            'years' => 365,
            default => 1,
        };

        return (int) $this->duration * $multiplier;
    }

    /**
     * Calculate the expected return amount
     */
    public function calculateExpectedReturn(float $amount): float
    {
        $returnPercentage = ($this->min_return + $this->max_return) / 2;

        // Simple ROI calculation
        if ($this->return_type === 'percentage') {
            return $amount * ($returnPercentage / 100) + $amount;
        }

        return $amount + $this->price; // Fixed amount return
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Check if the active column exists - this is used until the migration can be run
        static::addGlobalScope('defaultActive', function ($query) {
            if (!\Schema::hasColumn('plans', 'active')) {
                return $query;
            }

            return $query->where(function($q) {
                $q->where('active', true)->orWhereNull('active');
            });
        });
    }

    /**
     * Get active plans
     */
    public function scopeActive($query)
    {
        if (!\Schema::hasColumn('plans', 'active')) {
            return $query;
        }

        return $query->where('active', true);
    }

    /**
     * Get featured plans
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get plans by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('plan_category_id', $categoryId);
        });
    }
}
