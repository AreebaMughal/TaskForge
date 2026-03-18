<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(array $data): User
    {
        return User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);
    }
}
