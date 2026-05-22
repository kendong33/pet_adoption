<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the application.
     */
    public function view(User $user, Application $application): bool
    {
        // Admins can view any application
        if ($user->isAdmin()) {
            return true;
        }

        // Adopters can only view their own applications
        return $user->id === $application->user_id;
    }

    /**
     * Determine whether the user can create applications.
     */
    public function create(User $user): bool
    {
        return $user->isAdopter();
    }

    /**
     * Determine whether the user can update the application.
     */
    public function update(User $user, Application $application): bool
    {
        // Only admins can update applications
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the application.
     */
    public function delete(User $user, Application $application): bool
    {
        // Only admins can delete applications
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view application history.
     */
    public function viewHistory(User $user): bool
    {
        return $user->isAdmin();
    }
}
