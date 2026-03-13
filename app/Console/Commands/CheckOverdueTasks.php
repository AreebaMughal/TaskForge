<?php

namespace App\Console\Commands;

use App\Jobs\NotifyOverdueTask;
use App\Models\Task;
use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-overdue-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find overdue tasks and dispatch jobs notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueTasks = Task::with('project')->where('due_date', '<', today())->where('status', '!=', 'completed')->get();
        if($overdueTasks->isEmpty()){
            $this->info('no overdue task found');
            return;
        }
        foreach($overdueTasks as $task){
            NotifyOverdueTask::dispatch($task);
            $this->info('dispatched job for task'. $task->title);
        }
        $this->info('done'. $overdueTasks->count(). ' jobs dispatched');
    }
}
