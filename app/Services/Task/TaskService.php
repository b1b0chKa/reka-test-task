<?php

namespace App\Services\Task;

use App\DTO\Task\SortTaskDTO;
use App\DTO\Task\TaskDTO;
use App\DTO\Task\UpdateTaskDTO;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskService
{
    public function create(TaskDTO $dto): Task
    {
        return DB::transaction(function () use ($dto) {
            $task = Task::create([
                'user_id'   => $dto->user_id,
                'title'     => $dto->title,
                'text'      => $dto->text,
            ]);

            $this->syncTags($task, $dto->tags);

            return $task->load('tags');
        });
    }

    public function update(Task $task, UpdateTaskDTO $dto): Task
    {
        $task->update([
            'title' => $dto->title ?? $task->title,
            'text' => $dto->text ?? $task->text,
            'is_completed' => $dto->is_completed ?? $task->is_completed,
        ]);

        if (isset($dto->tags))
            $this->syncTags($task, $dto->tags);
        
        return $task->load('tags');
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function sort(SortTaskDTO $dto): void
    {
        foreach ($dto->tasks as $task) {
            Task::query()
                ->where('id', $task['id'])
                ->update([
                    'position' => $task['position'],
                ]);
        }
    }


    private function syncTags(Task $task, array $tagIds): void
    {
        $task->tags()->sync($tagIds);
    }
}
