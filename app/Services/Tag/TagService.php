<?php

namespace App\Services\Tag;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
	public function create(User $user, string $title): Tag
	{
		$normalized = mb_strtolower(trim($title));

		return Tag::firstOrCreate([
			'user_id' 	=> $user->id,
			'title' 	=> $normalized,
		]);
	}

	public function search(User $user, ?string $query = null): Collection
	{
		return Tag::query()
			->where('user_id', $user->id)
			->when($query, function ($q) use ($query) {
				$q->where('title', 'like', "%{$query}%");
			})
			->orderBy('title')
			->limit(10)
			->get();
	}
}
