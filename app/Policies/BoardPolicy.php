<?php

namespace App\Policies;

use App\Models\{Board, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Board $board): bool
    {
        return $board->getAttribute('user_id') === $user->getAttribute('id');
    }

    public function delete(User $user, Board $board): bool
    {
        return $board->getAttribute('user_id') === $user->getAttribute('id');
    }

}
