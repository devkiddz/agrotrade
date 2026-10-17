<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_plan_id',
        'user_id',
        'amount',
        'roi_percentage',
        'type',
        'status',
        'processed_at',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'roi_percentage' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user plan that owns the payout
     */
    public function userPlan(): BelongsTo
    {
        return $this->belongsTo(UserPlan::class);
    }

    /**
     * Get the user that owns the payout
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending payouts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processed payouts
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }
}
