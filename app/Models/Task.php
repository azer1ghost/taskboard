<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Relations\BelongsTo, Model, SoftDeletes};

/**
 * @method static create(array $validated)
 */
class Task extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['title', 'detail', 'board_id', 'order'];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($task) {
            // get max order number form same stage of task
            $order = self::query()
                ->where('board_id', $task->getAttribute('board_id'))
                ->max('order');

            $task->setAttribute('order', $order + 1);
        });

        static::updated(function ($task)
        {
            //TODO: iterate only 'board_id' or 'order' columns was updated

            // get all other tasks greater than this and re-iterate them
            $tasks = self::query()
                ->where('id', '!=', $task->getAttribute('id'))
                ->where('board_id', $task->getAttribute('board_id'))
                ->where('order', '>=', $task->getAttribute('order'))
                ->orderBy('order')
                ->get();

                $iterate = $task->getAttribute('order');

                foreach ($tasks as $singleTask) {
                    $iterate++;
                    $singleTask->update(['order' => $iterate]);
                };
        });
    }
}
