<?php

namespace App\Actions;

use App\Exceptions\InvalidTaskDateException;
use App\Exceptions\UserNotProjectMemberException;
use App\Models\Project;
use App\Models\Task;

class CreateTaskAction
{
    /**
     * Create a new class instance.
     */
    public function execute(array $task, int $id):Task
    {
        $project = Project::findorfail($task['project_id']);
        
        if($task['due_date'] < $project->start_date->format('Y-m-d')) {
            throw new InvalidTaskDateException();
        }
        $isMember = $project->members()->where('user_id', $id)->exists();
        if(!$isMember) {
            throw new UserNotProjectMemberException();
        }
        return Task::create([
            ...$task,
            'created_by' => $id,
        ]);
    }
}
