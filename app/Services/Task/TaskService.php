<?php

namespace App\Services\Task;

use App\DTO\Task\TaskDTO;
use App\Models\Task;

class TaskService
{
    public function create(TaskDTO $dto): Task
    {
        $task = Task::create([
            'user_id' => $dto->user_id,
            'title' => $dto->title,
            'text' => $dto->text,
        ]);

        $this->syncTags($task, $dto->tags);

        return $task->load('tags');
    }

    public function update(Task $task, array $data): Task
    {
        $task->update([
            'title' => $data['title'] ?? $task->title,
            'text' => $data['text'] ?? $task->text,
            'is_completed' => $data['is_completed'] ?? $task->is_completed,
        ]);

        if (isset($data['tags']))
            $this->syncTags($task, $data['tags']);
        
        return $task->load('tags');
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function sort(array $tasks): void
    {
        foreach ($tasks as $task) {
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
