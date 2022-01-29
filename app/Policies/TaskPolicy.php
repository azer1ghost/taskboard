<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        // TODO only self board
        return true;
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
