<?php

namespace App\DTO\Task;

class UpdateTaskDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $text = null,
        public readonly ?bool $is_completed = null,
        public readonly array $tags = [],
    ) {}
}
