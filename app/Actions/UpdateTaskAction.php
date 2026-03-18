<?php

namespace App\Actions;

use App\Exceptions\CannotUpdateTaskToArchivedProject;
use App\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, array $data): Task
    {
        if ($task->project->archived_at) {
            throw new CannotUpdateTaskToArchivedProject();
        }
        $task->update($data);
        return $task;
    }
}
