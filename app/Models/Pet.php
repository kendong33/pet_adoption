<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pet extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'category_id',
        'breed',
        'age',
        'gender',
        'health_status',
        'description',
        'image',
        'status',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'age' => 'integer',
    ];

    // ─────────────────────────────────────────────
    //  Relationships
    // ─────────────────────────────────────────────

    /**
     * Pet has many adoption applications.
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Pet belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ─────────────────────────────────────────────
    //  Query Scopes
    // ─────────────────────────────────────────────

    /**
     * Scope: only Available pets (for adopter gallery).
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'Available');
    }

    /**
     * Scope: full-text search across name, breed, category.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('breed', 'like', "%{$term}%")
              ->orWhereHas('category', function($q) use ($term) {
                  $q->where('category_name', 'like', "%{$term}%");
              });
        });
    }

    /**
     * Scope: filter by category.
     */
    public function scopeCategory(Builder $query, ?int $categoryId): Builder
    {
        if (!$categoryId) {
            return $query;
        }
    
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: filter by gender.
     */
    public function scopeGender(Builder $query, ?string $gender): Builder
    {
        if (!$gender) {
            return $query;
        }

        return $query->where('gender', $gender);
    }

    /**
     * Scope: filter by status.
     */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }
}
