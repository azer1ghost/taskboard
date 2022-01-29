<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasMany, SoftDeletes};

/**
 * @method static create(string[] $array)
 */
class Board extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'order'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    private function updateIteration($without)
    {
        $board = $without;

        // get all user's boards greater than this and re-iterate them
        $boards = self::query()
            ->where('id', '!=', $board->getAttribute('id'))
            ->where('user_id', auth()->id())
            ->where('order', '>=', $board->getAttribute('order'))
            ->orderBy('order')
            ->get();

        $iterate = $board->getAttribute('order');

        foreach ($boards as $singleBoard) {
            $iterate++;
            $singleBoard->update(['order' => $iterate]);
        };
    }

    protected static function booted()
    {
        static::creating(function ($board) {
            $board->setAttribute('order', 1);
        });

        static::created(function ($board){
            self::updateIteration($board);
        });

        static::updated(function ($board) {
            //TODO: iterate only 'order' columns was updated
            self::updateIteration($board);
        });
    }

}
