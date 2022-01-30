<?php

namespace App\Policies;

use App\Models\{Task, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->boards()->where('id', request('board_id'))->exists();
    }

    public function update(User $user, Task $task): bool
    {
        return $task->board()->pluck('user_id')->first() === $user->getAttribute('id');
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->board()->pluck('user_id')->first() === $user->getAttribute('id');
    }
}
