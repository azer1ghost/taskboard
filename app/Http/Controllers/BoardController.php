<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Jobs\RefreshIterateBoards;
use Illuminate\Http\JsonResponse;
use App\Models\Board;
use Exception;

class BoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Board::class);
    }

    public function index(): JsonResponse
    {
        try {
            return response()->json(
                auth()->user()
                ->boards()
                ->with('tasks')
                ->orderBy('order')
                ->get(['id', 'title', 'order'])
            );
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }

    public function store(BoardRequest $request): JsonResponse
    {
        try {
            $board = $request->user()->boards()->create($request->validated());
            $this->dispatch(new RefreshIterateBoards($board, 1));
            return response()->json($board->load('tasks'), 201);
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }

    public function update(Board $board, BoardRequest $request): JsonResponse
    {
        try {
            $oldOrder = $board->getAttribute('order');
            $board->update($request->validated());
            $this->dispatch(new RefreshIterateBoards($board, $oldOrder));
            return response()->json($board);
        } catch (Exception $e) {
            return response()->json($e, 202);
        }

    }

    public function destroy(Board $board)
    {
        try {
            $board->delete();
            return response('OK');
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }
}
