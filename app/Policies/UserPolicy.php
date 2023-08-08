<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->id == $model->id) {
            return $user->is_admin == Request::get('is_admin');
        }

        if ($user->id > $model->id) {
            return false;
        }

        return $user->id <= $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->id != $model->id && $user->id < $model->id;
    }
}
