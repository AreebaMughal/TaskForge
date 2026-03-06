<?php

namespace App\Actions;

use App\Exceptions\CannotDeleteClientException;
use App\Models\Client;

class DeleteClientAction
{
    /**
     * Create a new class instance.
     */
    public function execute(Client $client):void
    {
        $hasActiveProjects = $client->projects()->whereNull('archived_at')->where('status', 'active')->exists();
        if ($hasActiveProjects) {
            throw new CannotDeleteClientException();
        }
        $client->delete();
    }
}
