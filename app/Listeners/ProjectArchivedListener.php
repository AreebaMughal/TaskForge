<?php

namespace App\Listeners;

use App\Events\ProjectArchived;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProjectArchivedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProjectArchived $event): void
    {
        AuditLog::create([
            'project_id' => $event->project->id,
            'user_id' => $event->archivedById,
            'action' => 'archived',
            'note' => 'Project "' . $event->project->name . '" has archived.'
        ]);
    }
}
