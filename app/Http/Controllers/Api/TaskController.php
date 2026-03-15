<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Task::query()
            ->orderBy('id')
            ->get();

        return response()->json([
            'tasks' => TaskResource::collection($tasks)->resolve(),
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();

        $task = Task::query()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'done' => $data['done'] ?? false,
        ]);

        return response()->json([
            'task' => TaskResource::make($task)->resolve(),
        ], Response::HTTP_CREATED);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json([
            'task' => TaskResource::make($task)->resolve(),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return response()->json([
            'task' => TaskResource::make($task->refresh())->resolve(),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'result' => true,
        ]);
    }
}
