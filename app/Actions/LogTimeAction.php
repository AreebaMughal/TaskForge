<?php

namespace App\Actions;

use App\Exceptions\CannotLogtimeToArchivedProject;
use App\Exceptions\UserNotProjectMemberException;
use App\Models\Task;
use App\Models\Timelog;

class LogTimeAction
{
    /**
     * Create a new class instance.
     */
    public function execute(array $timelog, int $id) : Timelog
    {
        $task = Task::with('project.members')->findOrFail($timelog['task_id']);
        if($task->project->archived_at) {
            throw new CannotLogtimeToArchivedProject();
        }

        $isMember = $task->project->members()->where('user_id', $id)->exists();
        if(!$isMember){
            throw new UserNotProjectMemberException();
        }
        return Timelog::create([
            ...$timelog,
            'created_by' => $id,
        ]);
    }
}
