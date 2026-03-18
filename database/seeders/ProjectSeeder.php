<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::where('email', 'manager@gmail.com')->first();
        $manager1 = User::where('email', 'manager1@gmail.com')->first();
        $member = User::where('email', 'member@gmail.com')->first();
        $member1 = User::where('email', 'member1@gmail.com')->first();
        $member2 = User::where('email', 'member2@gmail.com')->first();

        $cruise = Client::where('contact_email', 'cruise@gmail.com')->first();
        $sparrow = Client::where('contact_email', 'sparrow@gmail.com')->first();
        $stark = Client::where('contact_email', 'stark@gmail.com')->first();
        $widow = Client::where('contact_email', 'widow@gmail.com')->first();
        $byers = Client::where('contact_email', 'byers@gmail.com')->first();

        $projects = [
            [
                'name' => 'Web Development',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $cruise->id,
                'created_by' => $manager->id,
                'members' => [$member->id, $member1->id],
            ],
            [
                'name' => 'Mobile App Development',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $stark->id,
                'created_by' => $manager1->id,
                'members' => [$member2->id,$member->id,$member1->id],
            ],
            [
                'name' => 'Game Development',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $widow->id,
                'created_by' => $manager->id,
                'members' => [$member2->id],
            ],
            [
                'name' => 'Weather App Development',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $sparrow->id,
                'created_by' => $manager1->id,
                'members' => [$member1->id],
            ],
            [
                'name' => 'Daily Status Report',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $byers->id,
                'created_by' => $manager->id,
                'members' => [$member->id, $member2->id],
            ],
            [
                'name' => 'Human Resource Management',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $cruise->id,
                'created_by' => $manager1->id,
                'members' => [$member1->id, $member2->id],
            ],
            [
                'name' => 'Daily Checker',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $sparrow->id,
                'created_by' => $manager->id,
                'members' => [$member->id, $member1->id],
            ],
            [
                'name' => 'Blog Post Management ',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $stark->id,
                'created_by' => $manager1->id,
                'members' => [$member1->id, $member2->id, $member->id],
            ],
            [
                'name' => 'Socail Media Marketer',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $widow->id,
                'created_by' => $manager->id,
                'members' => [$member->id],
            ],
            [
                'name' => 'Tool Management',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'due_date' => '2026-06-01',
                'client_id' => $cruise->id,
                'created_by' => $manager1->id,
                'members' => [$member->id, $member2->id],
            ],
            
        ];
        foreach($projects as $data){
            $members = $data['members'];
            unset($data['members']);
            $project = Project::create($data);
            $project->members()->attach($members);
        }
    }
}
