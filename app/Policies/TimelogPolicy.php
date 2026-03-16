<?php

namespace App\Policies;

use App\Models\Timelog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TimelogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Timelog $timelog): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isMember();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isMember();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timelog $timelog): bool
    {
        if ($timelog->task->project->archived_at) {
            return false;
        }

        return $user->isMember() && $timelog->created_by === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timelog $timelog): bool
    {
        if ($timelog->task->project->archived_at) {
            return false;
        }

        return $user->isMember() && $timelog->created_by === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Timelog $timelog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Timelog $timelog): bool
    {
        return false;
    }
}
