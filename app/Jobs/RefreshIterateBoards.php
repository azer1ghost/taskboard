<?php

namespace App\Jobs;

use App\Models\Board;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshIterateBoards
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $board, $oldOrder;

    public function __construct(Board $board, int $oldOrder)
    {
        $this->board = $board->withoutRelations();
        $this->oldOrder = $oldOrder;
    }

    public function handle()
    {
        // get all user's boards greater than this and re-iterate them
        $boards = Board::query()
            ->where('user_id', $this->board->getAttribute('user_id'))
            ->where('id', '!=', $this->board->getAttribute('id'))
            ->orderBy('order')
            ->get();

        $increase = $this->board->order;

        foreach ($boards as $board) {
            if ($board->order <= $this->board->order && $this->board->order > $this->oldOrder) {
                $board->decrement('order');
            }
            elseif ($board->order >= $this->board->order) {
                $increase++;
                $board->update(['order' => $increase]);
            }
        }
    }
}



