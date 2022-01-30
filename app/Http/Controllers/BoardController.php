<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Jobs\RefreshIterateBoards;
use Illuminate\Http\JsonResponse;
use App\Models\Board;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Board::class);
    }

    public function index(): JsonResponse
    {
         $boards = auth()->user()
                ->boards()
                ->with('tasks')
                ->orderBy('order')
                ->get(['id', 'title', 'order']);

         return response()->json($boards);
    }

    public function store(BoardRequest $request): JsonResponse
    {
        $board = $request->user()->boards()->create($request->validated());

        $this->dispatch(new RefreshIterateBoards($board));

        return response()->json($board->load('tasks'), 201);
    }

    public function update(Board $board, BoardRequest $request): JsonResponse
    {
        $board->update($request->validated());

        $this->dispatch(new RefreshIterateBoards($board));

        return response()->json($board);
    }

    public function destroy(Board $board)
    {
        $board->delete();

        return response('OK');
    }
}


//        if ($board->isDirty('order')){
//        }
//        $board->save();
