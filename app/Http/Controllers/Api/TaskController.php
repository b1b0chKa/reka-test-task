<?php

namespace App\Http\Controllers\Api;

use App\DTO\Task\TaskDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\SortTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Services\Task\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $tasks = $request->user()
            ->tasks()
            ->with('tags')
            ->orderBy('position')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json([
            'data' => new TaskResource($tasks),
            'meta' => [
                'current_page'  => $tasks->currentPage(),
                'last_page'     => $tasks->lastPage(),
                'per_page'      => $tasks->perPage(),
                'total'         => $tasks->total(),
            ],
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $dto = new TaskDTO(
            user_id: $request->user()->id,
            title: $request->validated('title'),
            text: $request->validated('text'),
            tags: $request->validated('tags', []),
        );

        $task = $this->taskService->create($dto);

        return response()->json([
            'data' => new TaskResource($task),
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorizeTask($task);

        return response()->json([
            'data' => new TaskResource($task->load('tags')),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorizeTask($task);

        $task = $this->taskService->update($task, $request->validated());

        return response()->json([
            'data' => new TaskResource($task),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        
        $this->taskService->delete($task);

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }

    public function sort(SortTaskRequest $request): JsonResponse
    {
        $this->taskService->sort($request->validated('tasks'));

        return response()->json([
            'message' => 'Task sorted successfully'
        ]);
    }


    private function authorizeTask(Task $task): void
    {
        abort_if(
            $task->user_id !== auth()->id(),
            403,
            'Access denied'
        );
    }
}
