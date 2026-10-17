<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'feature',
        'included',
        'icon',
        'sort_order',
    ];

    protected $casts = [
        'included' => 'boolean',
    ];

    /**
     * Get the plan that owns the feature
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
