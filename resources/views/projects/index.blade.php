<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex item-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">Projects</h2>
            @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create')}}" class=" bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Add new Project
            </a>
            @endcan
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{session('success')}}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{session('error')}}
            </div>
            @endif
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tasks</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-900">{{ $project->name }}</p>
                                @if($project->archived_at)
                                <p class="text-xs text-gray-400 mt-0.5">Archived {{ $project->archived_at->format('M d, Y') }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($project->archived_at)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Archived</span>
                                @elseif($project->status === 'active')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->client->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->tasks_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $project->due_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm space-x-3">
                                <a href="{{ route('projects.show', $project) }}"
                                    class="text-gray-500 hover:text-indigo-600 transition">View</a>
                                @can('update', $project)
                                @unless($project->archived_at)
                                <a href="{{ route('projects.edit', $project) }}"
                                    class="text-gray-500 hover:text-indigo-600 transition">Edit</a>
                                @endunless
                                @endcan
                                @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-gray-500 hover:text-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                No projects found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($projects->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $projects->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>