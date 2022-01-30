<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Jobs\RefreshIterateTasks;
use Illuminate\Http\JsonResponse;
use App\Models\Task;
use Exception;

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
            $task = Task::create($request->validated());
            $this->dispatch(new RefreshIterateTasks($task));
            return response()->json($task, 201);
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }

    public function update(Task $task, TaskRequest $request): JsonResponse
    {
        try {
            $oldOrder = $task->getAttribute('order');
            $task->update($request->validated());
            $this->dispatch(new RefreshIterateTasks($task, $oldOrder));
            return response()->json($task);
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response('OK');
        } catch (Exception $e) {
            return response()->json($e, 202);
        }
    }
}
