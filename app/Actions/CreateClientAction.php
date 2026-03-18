<?php

namespace App\Actions;

use App\Models\Client;

class CreateClientAction
{
    public function execute(array $data, int $userId): Client
    {
        return Client::create([
            ...$data,
            'created_by' => $userId,
        ]);
    }
}
