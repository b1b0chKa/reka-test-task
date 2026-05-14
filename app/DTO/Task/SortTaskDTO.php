<?php

namespace App\DTO\Task;

class SortTaskDTO
{
    public function __construct(
        public readonly array $tasks,
    ) {}
}
