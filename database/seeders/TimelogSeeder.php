<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Timelog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimelogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = Task::with('project.members')->get();
        $notes = [
            'researching, analyzing and planning',
            'fixing bugs',
            'working on implementation',
            'working on development',
            'writing test cases',
            'writing documentation',
            'performing edge cases',
            'analyzing functional requriements',
            'analyzing business requirement',
            'giving final review and feedback'
        ];
        $timelogCount = 0;
        foreach ($tasks as $task) {
            $members = $task->project->members;
            if ($members->isEmpty()) {
                continue;
            }
            $taskLogs = $timelogCount < 90 ? 3 : 4;
            for ($i = 0; $i < $taskLogs; $i++) {
                $member = $members[$i % $members->count()];
                Timelog::create([
                    'minutes'    => rand(30, 480),
                    'note'       => $notes[($timelogCount + $i) % count($notes)],
                    'task_id'    => $task->id,
                    'user_id' => $member->id,
                    'logged_at' => fake()->dateTimeBetween('-1 year', 'now'),
                ]);
                $timelogCount++;
                if ($timelogCount >= 100) {
                    return;
                }
            }
        }
    }
}
