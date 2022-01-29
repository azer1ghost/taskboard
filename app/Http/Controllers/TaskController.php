<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Task::class);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        try {
            return response()->json(Task::create($request->validated()), 201);
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function update(Task $task, TaskRequest $request): JsonResponse
    {
        try {
            return response()->json($task->update($request->validated()));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response('OK');
        } catch (Exception $e) {
            dd($e);
        }
    }
}
