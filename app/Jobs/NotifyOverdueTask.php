<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskOverDueNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyOverdueTask implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Task $task
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->task->load('project.user');
        $manager = $this->task->project->user;
        if(!$manager){
            $this->fail('no manager found');
        }
        $manager->notify(new TaskOverDueNotification(($this->task)));
    }
}
