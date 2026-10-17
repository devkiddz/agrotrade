<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class PlanCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active',
        'sort_order',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the plans in this category
     */
    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class, 'plan_plan_category')->withoutGlobalScopes();
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Check if the active column exists - this is used until the migration can be run
        static::addGlobalScope('defaultActive', function ($query) {
            if (!\Schema::hasColumn('plan_categories', 'active')) {
                return $query;
            }

            return $query->where(function($q) {
                $q->where('active', true)->orWhereNull('active');
            });
        });
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        if (!\Schema::hasColumn('plan_categories', 'active')) {
            return $query;
        }

        return $query->where('active', true);
    }
}
