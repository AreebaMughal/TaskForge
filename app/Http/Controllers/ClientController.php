<?php

namespace App\Http\Controllers;

use App\Actions\DeleteClientAction;
use App\Exceptions\CannotDeleteClientException;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::withCount('projects')
            ->when(auth()->user()->isManager(), function ($query) {
                return $query->where('created_by', auth()->id());
            })
            ->latest()
            ->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Client::class);
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request, \App\Actions\CreateClientAction $action)
    {
        $action->execute($request->validated(), auth()->id());
        return redirect()->route('clients.index')->with('success', 'client created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $this->authorize('view', $client);
        $client->load('projects'); //eager loading
        return view('clients.show',compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $this->authorize('update', $client);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client, \App\Actions\UpdateClientAction $action)
    {
        $action->execute($client, $request->validated());
        return redirect()->route('clients.index')->with('success', 'client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client, DeleteClientAction $action)
    {
        $this->authorize('delete', $client);
        try{
            $action->execute($client);
        } catch (CannotDeleteClientException $e){
            return back()->with('error', $e->getMessage());
        }
        return redirect()->route('clients.index')->with('success', 'client deleted');
    }
}
