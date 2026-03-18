<?php

namespace App\Actions;

use App\Exceptions\CannotUpdateTimelogToArchivedProject;
use App\Models\Timelog;

class UpdateTimelogAction
{
    public function execute(Timelog $timelog, array $data): Timelog
    {
        if ($timelog->task->project->archived_at) {
            throw new CannotUpdateTimelogToArchivedProject();
        }
        $timelog->update($data);
        return $timelog;
    }
}
