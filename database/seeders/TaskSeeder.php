<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::with('members')->get();
        $tasks = [
            ['title' => 'Ui/Ux Improvement', 'description' => 'ui should be improved in this section'],
            ['title' => 'Backend Issue', 'description' => 'backend fix need in this section'],
            ['title' => 'Frontend Issue', 'description' => 'frontend fix need in this section'],
            ['title' => 'Documentation', 'description' => 'documentation need for this module'],
            ['title' => 'Testing', 'description' => 'testing need for this section'],
            ['title' => 'DB Issue', 'description' => 'db issue appeared in this module'],
            ['title' => 'API Integration', 'description' => 'api integration need for this module'],
            ['title' => 'Responsiveness', 'description' => 'responsiveness need in this section'],
            ['title' => 'Functional Requirement', 'description' => 'functional requirement need in this section'],
            ['title' => 'Engineering Requirement', 'description' => 'engineering requirement need in this section'],
        ];
        $taskCount = 0;
        foreach ($projects as $project) {
            $members = $project->members;
            if($members -> isEmpty()){
                continue;
            }
            for ($i=0; $i < 3; $i++) { 
                $task = $tasks[$taskCount % count($tasks)];
                $member = $members[$i % $members->count()];
                $status = $taskCount % 4 === 0 ? 'completed' : 'in_progress';
                $due_date = date('Y-m-d', strtotime($project->start_date . ' +' . (($i+1)*20). ' days'));
                Task::create([
                    'title' => $task['title'],
                    'description' => $task['description'],
                    'status' => $status,
                    'due_date' => $due_date,
                    'project_id' => $project->id,
                    'created_by' => $member->id,
                ]);
                $taskCount++;
            }
        }
    }
}
