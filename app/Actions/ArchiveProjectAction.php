<?php

namespace App\Actions;

use App\Exceptions\CannotArchiveProjectException;
use App\Models\Project;

use function Symfony\Component\Clock\now;

class ArchiveProjectAction
{
    /**
     * Create a new class instance.
     */
    public function execute(Project $project):void
    {
        $hasActiveProject = $project->tasks()->where('status','in_progress')->exists();
        if($hasActiveProject){
            throw new CannotArchiveProjectException();
        }
        $project->update(['archived_at'=> now()]);
    }
}
