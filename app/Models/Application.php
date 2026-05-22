<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'pet_id',
        'adopter_name',
        'contact_number',
        'address',
        'home_background',
        'application_date',
        'application_status',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'application_date' => 'date',
    ];

    // ─────────────────────────────────────────────
    //  Relationships
    // ─────────────────────────────────────────────

    /**
     * Application belongs to a User (adopter).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Application belongs to a Pet.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    // ─────────────────────────────────────────────
    //  Query Scopes
    // ─────────────────────────────────────────────

    /**
     * Scope: Get applications with 'Pending' status.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('application_status', 'Pending');
    }

    /**
     * Scope: Get applications with 'Approved' status.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('application_status', 'Approved');
    }

    /**
     * Scope: Get applications with 'Declined' status.
     */
    public function scopeDeclined(Builder $query): Builder
    {
        return $query->where('application_status', 'Declined');
    }

    /**
     * Scope: Get applications with 'Interview Scheduled' status.
     */
    public function scopeInterviewScheduled(Builder $query): Builder
    {
        return $query->where('application_status', 'Interview Scheduled');
    }

    /**
     * Scope: Search applications by adopter name or pet name.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('adopter_name', 'like', "%{$term}%")
              ->orWhereHas('pet', function (Builder $petQuery) use ($term) {
                  $petQuery->where('name', 'like', "%{$term}%");
              });
        });
    }

    /**
     * Scope: Filter by status.
     */
    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        if (!$status) {
            return $query;
        }

        return $query->where('application_status', $status);
    }

    /**
     * Scope: Filter by date range.
     */
    public function scopeDateRange(Builder $query, ?string $startDate, ?string $endDate): Builder
    {
        if ($startDate) {
            $query->whereDate('application_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('application_date', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Scope: Filter by pet category.
     */
    public function scopeByCategory(Builder $query, ?string $categoryId): Builder
    {
        if (!$categoryId) {
            return $query;
        }

        return $query->whereHas('pet', function (Builder $petQuery) use ($categoryId) {
            $petQuery->where('category_id', $categoryId);
        });
    }

    /**
     * Scope: Recent first (latest applications).
     */
    public function scopeRecentFirst(Builder $query): Builder
    {
        return $query->orderByDesc('application_date');
    }

    // ─────────────────────────────────────────────
    //  Helper Methods
    // ─────────────────────────────────────────────

    /**
     * Check if application is pending.
     */
    public function isPending(): bool
    {
        return $this->application_status === 'Pending';
    }

    /**
     * Check if application is approved.
     */
    public function isApproved(): bool
    {
        return $this->application_status === 'Approved';
    }

    /**
     * Check if application is declined.
     */
    public function isDeclined(): bool
    {
        return $this->application_status === 'Declined';
    }

    /**
     * Check if application has interview scheduled.
     */
    public function hasInterviewScheduled(): bool
    {
        return $this->application_status === 'Interview Scheduled';
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusColor(): string
    {
        return match ($this->application_status) {
            'Pending' => 'yellow',
            'Interview Scheduled' => 'blue',
            'Approved' => 'green',
            'Declined' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status badge class for Tailwind.
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->application_status) {
            'Pending' => 'bg-yellow-100 text-yellow-800',
            'Interview Scheduled' => 'bg-blue-100 text-blue-800',
            'Approved' => 'bg-green-100 text-green-800',
            'Declined' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status icon for UI.
     */
    public function getStatusIcon(): string
    {
        return match ($this->application_status) {
            'Pending' => '',
            'Interview Scheduled' => '',
            'Approved' => '',
            'Declined' => '',
            default => '',
        };
    }
}
