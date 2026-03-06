<?php

namespace App\Actions;

use App\Models\Project;

class AssignMembersAction
{
    /**
     * Create a new class instance.
     */
    public function execute(Project $project, array $memberId):void
    {
        $project->members()->sync($memberId);
    }
}
