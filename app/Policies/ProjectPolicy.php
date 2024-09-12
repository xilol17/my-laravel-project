<?php

namespace App\Policies;

use App\Models\project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function edit(User $user, project $project): bool
    {
        if ($project->sales) {
            // Check if the project's sales user is the current user
            return $project->sales->user->is($user);
        }

        // If there's no sales record, return false
        return false;
    }

}
