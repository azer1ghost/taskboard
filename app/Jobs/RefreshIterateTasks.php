<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshIterateTasks
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task, $oldOrder;

    public function __construct(Task $task, ?int $oldOrder = null)
    {
        $this->task = $task->withoutRelations();
        $this->oldOrder = $oldOrder;
    }

    public function handle()
    {
        // get all other tasks greater than this and re-iterate them
        $tasks = Task::query()
            ->where('id', '!=', $this->task->getAttribute('id'))
            ->where('board_id', $this->task->getAttribute('board_id'))
            ->where('order', '>=', $this->task->getAttribute('order'))
            ->orderBy('order')
            ->get();

        $increase = $this->task->order;

        foreach ($tasks as $task) {
            if ($task->order <= $this->task->order && $this->task->order > $this->oldOrder) {
                $task->decrement('order');
            }
            elseif ($task->order >= $this->task->order) {
                $increase++;
                $task->update(['order' => $increase]);
            }
        }
    }
}



