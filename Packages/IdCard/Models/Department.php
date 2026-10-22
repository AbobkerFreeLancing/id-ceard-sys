<?php

namespace Packages\IdCard\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $table = 'idcard_departments';

    protected $fillable = [
        'organization_id',
        'parent_id',
        'name',
        'code',
        'classification',
        'depth_level',
        'order_column',
        'color_hex',
        'metadata_json',
        'is_active',
    ];

    protected $casts = [
        'metadata_json' => 'array',
        'depth_level' => 'integer',
        'order_column' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Parent Department / Classification in the tree.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Immediate Child Departments / Sub-categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order_column');
    }

    /**
     * Recursive all descendants.
     */
    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Organization.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Cardholders directly enrolled in this department/category.
     */
    public function cardholders(): HasMany
    {
        return $this->hasMany(Cardholder::class, 'department_id');
    }

    /**
     * Scope: Only Root / Top-Level nodes.
     */
    public function scopeRoots(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: Filter by classification type.
     */
    public function scopeClassification(Builder $query, string $type): Builder
    {
        return $query->where('classification', $type);
    }

    /**
     * Breadcrumb-style full hierarchical path (e.g. "الإدارة العامة > قطاع التقنية > قسم الشبكات").
     */
    public function getFullPathAttribute(): string
    {
        $path = [$this->name];
        $current = $this->parent;

        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }

        return implode(' > ', $path);
    }
}
