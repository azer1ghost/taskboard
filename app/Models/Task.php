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
    }
}
