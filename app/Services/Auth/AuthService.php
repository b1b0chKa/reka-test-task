<?php

namespace App\Services\Auth;

use App\DTO\Auth\UserAuthDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
	public function register(array $data): UserAuthDTO
	{
		$user = User::create([
			'name' 		=> $data['name'],
			'email' 	=> $data['email'],
			'password' 	=> Hash::make($data['password']),
		]);

		$token = $this->generateToken($user);

		$user->update([
			'api_token' => $token,
		]);

		return $this->map($user, $token);
	}

	public function login(array $data): UserAuthDTO
	{
		$user = User::where('email', $data['email'])->first();

		if (!$user || !Hash::check($data['password'], $user->password))
			throw new \Exception('Invalid credentials');

		if (!$user->api_token) {
			$user->api_token = $this->generateToken($user);
			$user->save();
		}

		return $this->map($user, $user->api_token);
	}

	private function generateToken(User $user): string
	{
		return hash('sha256', $user->id . $user->email . microtime(true));
	}

	private function map(User $user, string $token): UserAuthDTO
	{
		return new UserAuthDTO(
			id: $user->id,
			name: $user->name,
			email: $user->email,
			token: $token,
		);
	}
}
