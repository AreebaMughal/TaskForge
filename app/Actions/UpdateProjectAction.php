<?php

namespace App\Actions;

use App\Models\Project;

class UpdateProjectAction
{
    public function execute(Project $project, array $data): Project
    {
        $project->update($data);
        if (isset($data['members'])) {
            $project->members()->sync($data['members']);
        }
        return $project;
    }
}
