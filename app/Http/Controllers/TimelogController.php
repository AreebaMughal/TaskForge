<?php

namespace App\Http\Controllers;

use App\Actions\LogTimeAction;
use App\Http\Requests\StoreTimelogRequest;
use App\Http\Requests\UpdateTimelogRequest;
use App\Models\Timelog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TimelogController extends Controller
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
        $this->authorize('create', Timelog::class);
        $timelog = request('task');
        return view('timelogs.create', compact('taskId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimelogRequest $request, LogTimeAction $action)
    {
        try{
            $action->execute($request->validated(), auth()->id());
        }catch(\Exception $e){
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('tasks.show', $request->task_id)->with('success', 'Timelog successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Timelog $timelog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timelog $timelog)
    {
        $this->authorize('update', Timelog::class);
        return view('timelogs.edit', compact('timelog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimelogRequest $request, Timelog $timelog)
    {
        $timelog->update($request->validated());
        return redirect()->route('tasks.show', $timelog->task_id)->with('success', 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timelog $timelog)
    {
        $this->authorize('delete', $timelog);
        $taskId = $timelog->task_id;
        $timelog->delete();
        return redirect()->route('tasks.show', $taskId)->with('success', 'deleted');
    }
}
