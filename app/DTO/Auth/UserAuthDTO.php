<?php

namespace App\DTO\Auth;

class UserAuthDTO
{
	public function __construct(
		public readonly int $id,
		public readonly string $name,
		public readonly string $email,
		public readonly string $token,
	) {}
}