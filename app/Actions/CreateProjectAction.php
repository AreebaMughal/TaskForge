<?php

namespace App\Actions;

use App\Models\Project;

class CreateProjectAction
{
    public function execute(array $data, int $userId): Project
    {
        return Project::create([
            ...$data,
            'created_by' => $userId,
        ]);
    }
}
