<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class UserPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'plan_id',
        'invested_amount',
        'current_value',
        'roi_percentage',
        'expected_return',
        'total_profit',
        'status',
        'activated_at',
        'expires_at',
        'last_payout_at',
        'compounding_enabled',
        'compounding_percentage',
        'payment_method',
        'payment_reference',
        'notes',
    ];

    protected $casts = [
        'invested_amount' => 'decimal:8',
        'current_value' => 'decimal:8',
        'roi_percentage' => 'decimal:2',
        'expected_return' => 'decimal:8',
        'total_profit' => 'decimal:8',
        'compounding_enabled' => 'boolean',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_payout_at' => 'datetime',
    ];

    /**
     * Get the user that owns the plan
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plan
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the payouts for this user plan
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(PlanPayout::class);
    }

    /**
     * Calculate the remaining days
     */
    public function getRemainingDays(): int
    {
        if (!$this->activated_at || !$this->expires_at) {
            return 0;
        }

        if ($this->status !== 'active') {
            return 0;
        }

        $today = Carbon::now();
        if ($today->gt($this->expires_at)) {
            return 0;
        }

        return $today->diffInDays($this->expires_at);
    }

    /**
     * Calculate the progress percentage
     */
    public function getProgressPercentage(): float
    {
        if (!$this->activated_at || !$this->expires_at) {
            return 0;
        }

        $totalDays = $this->activated_at->diffInDays($this->expires_at);
        if ($totalDays <= 0) {
            return 100;
        }

        $elapsedDays = $this->activated_at->diffInDays(Carbon::now());

        // Cap at 100%
        $percentage = min(100, ($elapsedDays / $totalDays) * 100);

        return round($percentage, 2);
    }

    /**
     * Check if the plan has matured
     */
    public function hasMatured(): bool
    {
        if (!$this->expires_at) {
            return false;
        }

        return Carbon::now()->gte($this->expires_at);
    }

    /**
     * Scope for active plans
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed plans
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending plans
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
