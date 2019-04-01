<?php

namespace App\Policies;

use App\User;

class UserPolicy
{

    const ADMIN = 'admin';
    const DELETE = 'delete';

    /**
     * Determine if the current logged in user can see the admin section.
     */
    public function admin(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the current logged in user can delete a user.
     */
    public function delete(User $user, User $subject): bool
    {
        return $user->isAdmin() && ! $subject->isAdmin();
    }
}
