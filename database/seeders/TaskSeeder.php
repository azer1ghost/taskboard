<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    protected $fillable = ['title', 'detail'];

    public function run()
    {
        Task::factory(20)->create();
    }
}
