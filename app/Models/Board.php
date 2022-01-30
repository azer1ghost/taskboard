<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\BelongsTo, Relations\HasMany, SoftDeletes};

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($board) {
            $board->setAttribute('order', 1);
        });
    }

}
