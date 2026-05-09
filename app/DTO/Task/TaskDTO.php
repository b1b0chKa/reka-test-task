<?php

namespace App\DTO\Task;

class TaskDTO
{
	public function __construct(
		public readonly int $user_id,
		public readonly string $title,
		public readonly ?string $text = null,
		public readonly array $tags = [],
	) {}
}