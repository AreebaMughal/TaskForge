<?php

namespace App\Http\Controllers;

use App\Actions\ArchiveProjectAction;
use App\Actions\AssignMembersAction;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Project::class);
        $projects = Project::with('client')->withCount('tasks')->when(request('status'),fn($q, $status) => $q->where('status', $status))->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Project::class);
        $clients=Client::all();
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create([
            ...$request->validated(),
            'created_by'=> auth()->id()
        ]);
        return redirect()->route('projects.index')->with('success', 'project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('viewAny', $project);
        $project->load(['client', 'tasks', 'members']);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $clients = Client::all();
        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('projects.index')->with('success', 'project successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'project deleted successfully');
    }

    public function archive(Project $project, ArchiveProjectAction $action){
        $this->authorize('update', $project);
        try{
            $action->execute($project, auth()->id());
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('projects.index')->with('success', 'project archived successfully');
    }

    public function assignMembers(Project $project, AssignMembersAction $action){
        $this->authorize('update', $project);
        $action->execute($project, request('members', []));
        return back()->with('success', 'member assigned. congratulations!');
    }
}
