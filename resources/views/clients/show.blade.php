<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('clients.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    Back
                </a>
                <h2 class="text-xl font-semibold text-gray-800">{{ $client->name }}</h2>
            </div>
            @can('update', $client)
                <a href="{{ route('clients.edit', $client) }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Edit Client
                </a>
            @endcan
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Client details card --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Client Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Name</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $client->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Contact Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $client->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Created</dt>
                        <dd class="text-sm text-gray-700">{{ $client->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Total Projects</dt>
                        <dd class="text-sm text-gray-700">{{ $client->projects->count() }}</dd>
                    </div>
                </dl>
            </div>
            {{-- Projects list --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-700">Projects</h3>
                </div>
                @forelse($client->projects as $project)
                    <div class="px-6 py-4 border-b border-gray-50 last:border-0 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Due {{ $project->due_date->format('M d, Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Status badge --}}
                            @if($project->archived_at)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    Archived
                                </span>
                            @elseif($project->status === 'active')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Active
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                    Inactive
                                </span>
                            @endif
                            <a href="{{ route('projects.show', $project) }}"
                               class="text-xs text-indigo-600 hover:text-indigo-800 transition">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-gray-400">
                        No projects for this client.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>