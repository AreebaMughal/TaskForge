<?php

namespace Tests\Feature;

use App\Jobs\NotifyOverdueTask;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timelog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class TaskForgeTest extends TestCase
{
    use RefreshDatabase;

    // T1 — Member cannot access clients
    public function test_member_cannot_view_clients(): void
    {
        $member = User::factory()->member()->create();
        $response = $this->actingAs($member)->get(route('clients.index'));
        $response->assertStatus(403);
    }

    // T2 — Manager can create a client
    public function test_manager_can_create_client(): void
    {
        $manager = User::factory()->manager()->create();
        $response = $this->actingAs($manager)->post(route('clients.store'), [
            'name'  => 'Testing Client',
            'email' => 'test@gmail.com',
        ]);
        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', ['name' => 'Testing Client']);
    }

    // T3 — Validation error when creating client with no data
    public function test_client_creation_requires_name_and_email(): void
    {
        $manager = User::factory()->manager()->create();
        $response = $this->actingAs($manager)->post(route('clients.store'), []);
        $response->assertSessionHasErrors(['name', 'email']);
    }

    // T4 — Cannot delete client with active projects
    public function test_cannot_delete_client_with_active_projects(): void
    {
        $manager = User::factory()->manager()->create();
        $client = Client::factory()->create(['created_by' => $manager->id]);
        Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager->id,
            'archived_at' => null,
        ]);
        $response = $this->actingAs($manager)->delete(route('clients.destroy', $client));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('clients', ['id' => $client->id]);
    }

    // T5 — Cannot archive project with incomplete tasks
    public function test_cannot_archive_project_with_incomplete_tasks(): void
    {
        $manager = User::factory()->manager()->create();
        $client  = Client::factory()->create(['created_by' => $manager->id]);
        $project = Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager->id,
        ]);
        Task::factory()->create([
            'project_id' => $project->id,
            'created_by' => $manager->id,
            'status'     => 'in_progress',
        ]);
        $response = $this->actingAs($manager)->post(route('projects.archive', $project));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('projects', [
            'id'          => $project->id,
            'archived_at' => now(),
        ]);
    }

    // T6 — Manager cannot edit another manager's project
    public function test_manager_cannot_edit_another_managers_project(): void
    {
        $manager1 = User::factory()->manager()->create();
        $manager2 = User::factory()->manager()->create();
        $client   = Client::factory()->create(['created_by' => $manager1->id]);
        $project = Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager1->id,
        ]);
        $response = $this->actingAs($manager2)->get(route('projects.edit', $project));
        $response->assertStatus(403);
    }

    // TEST 7 — Timelog minutes validation
    public function test_timelog_minutes_cannot_exceed_600(): void
    {
        $member  = User::factory()->member()->create();
        $manager = User::factory()->manager()->create();
        $client  = Client::factory()->create(['created_by' => $manager->id]);
        $project = Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager->id,
        ]);
        $project->members()->attach($member->id);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'created_by' => $member->id,
        ]);
        $response = $this->actingAs($member)->post(route('timelogs.store'), [
            'task_id' => $task->id,
            'minutes' => 700,
            'note'    => 'Too many minutes',
        ]);
        $response->assertSessionHasErrors(['minutes']);
    }

    // T8 — Member cannot edit another member's timelog
    public function test_member_cannot_edit_another_members_timelog(): void
    {
        $member1 = User::factory()->member()->create();
        $member2 = User::factory()->member()->create();
        $manager = User::factory()->manager()->create();
        $client  = Client::factory()->create(['created_by' => $manager->id]);
        $project = Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager->id,
        ]);
        $project->members()->attach([$member1->id, $member2->id]);
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'created_by' => $member1->id,
        ]);
        $timelog = Timelog::factory()->create([
            'task_id'    => $task->id,
            'created_by' => $member1->id,
        ]);
        $response = $this->actingAs($member2)->get(route('timelogs.edit', $timelog));
        $response->assertStatus(403);
    }

    // TEST 9 — Overdue task dispatches queued job
    public function test_overdue_task_check_dispatches_job(): void
    {
        Queue::fake();
        $member  = User::factory()->member()->create();
        $manager = User::factory()->manager()->create();
        $client  = Client::factory()->create(['created_by' => $manager->id]);
        $project = Project::factory()->create([
            'client_id'  => $client->id,
            'created_by' => $manager->id,
        ]);
        Task::factory()->create([
            'project_id' => $project->id,
            'created_by' => $member->id,
            'due_date'   => now()->subDays(3),
            'status'     => 'in_progress',
        ]);
        $this->artisan('app:check-overdue-tasks');
        Queue::assertPushed(NotifyOverdueTask::class);
    }

    // TEST 10 — Admin can create users, member cannot
    public function test_only_admin_can_access_user_management(): void
    {
        $admin  = User::factory()->admin()->create();
        $member = User::factory()->member()->create();
        $this->actingAs($admin)->get(route('users.index'))->assertStatus(200);
        $this->actingAs($member)->get(route('users.index'))->assertStatus(403);
    }
}