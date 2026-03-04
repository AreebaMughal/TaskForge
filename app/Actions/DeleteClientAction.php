<?php

namespace App\Actions;

use App\Models\Client;

class DeleteClientAction
{
    /**
     * Create a new class instance.
     */
    public function execute(Client $client): void
    {
        $hasActiveProjects = $client->projects()->whereNull('archived_at')->exists();
        if ($hasActiveProjects) {
            throw new \Exception('Cant delete a client that has active project');
        }
        $client->delete();
    }
}
