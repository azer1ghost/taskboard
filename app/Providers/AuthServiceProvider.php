<?php

namespace App\Providers;

use App\Models\{Board, Task};
use App\Policies\{BoardPolicy, TaskPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
         Task::class  => TaskPolicy::class,
         Board::class => BoardPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
