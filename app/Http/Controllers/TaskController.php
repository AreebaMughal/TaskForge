<?php

namespace App\Http\Controllers;

use App\Actions\CreateTaskAction;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\View\ViewFinderInterface;

class TaskController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);
        $projectId = request('project');
        $projects = Project::whereNull('archived_at')->get();
        return view('tasks.create', compact('projectId', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, CreateTaskAction $action)
    {
        try{
            $action->execute($request->validated(), auth()->id());
        }catch(\Exception $e){
            return back()->withInput()->with('error', $e->getMessage());
        }
        return redirect()->route('projects.show', $request->project_id )->with('success', 'task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        $task->load('project','timelogs.user');
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', Task::class);
        return view('tasks.edit',compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->updated($request->validated());
        return redirect()->route('tasks.show', $task)->with('success', 'project successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('projects.show', $task->project_id)->with('success', 'task deleted');
    }
}
