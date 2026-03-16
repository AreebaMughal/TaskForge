<div>
    <!-- Act only according to that maxim whereby you can, at the same time, will that it should become a universal law. - Immanuel Kant -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class=" flex-column ">
                <a href="javascript:history.back()" class="text-gray-400 hover:text-gray-600 transition">
                    Back
                </a>

                @if($project->archived_at)
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Archived</span>
                @endif
            </div>
            @can('update', $project)
            <div class="flex items-center gap-2">
                @unless($project->archived_at)
                <a href="{{ route('projects.edit', $project) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Edit
                </a>
                <form action="{{ route('projects.archive', $project) }}" method="POST"
                    onsubmit="return confirm('Archive this project? This cannot be undone.')">
                    @csrf
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Archive
                    </button>
                </form>
                @endunless
            </div>
            @endcan
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Project Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Name</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $project->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Client</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $project->client?->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Status</dt>
                        <dd>
                            @if($project->archived_at)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Archived</span>
                            @elseif($project->status === 'active')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Inactive</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Start Date</dt>
                        <dd class="text-sm text-gray-700">{{ $project->start_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Due Date</dt>
                        <dd class="text-sm text-gray-700">{{ $project->due_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Total Tasks</dt>
                        <dd class="text-sm text-gray-700">{{ $project->tasks->count() }}</dd>
                    </div>
                </dl>
            </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-700">Tasks ({{ $project->tasks->count() }})</h3>
                        @can('create', App\Models\Task::class)
                        @unless($project->archived_at)
                        <a href="{{ route('tasks.create', ['project' => $project->id]) }}"
                            class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg transition">
                            + Add Task
                        </a>
                        @endunless
                        @endcan
                    </div>

                    @forelse($project->tasks as $task)
                    <div class="px-6 py-4 border-b border-gray-50 last:border-0 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $task->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Due {{ $task->due_date->format('M d, Y') }}· {{ $task->timelogs->sum('minutes') }} mins logged</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($task->status === 'completed')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">In Progress</span>
                            @endif
                            <a href="{{ route('tasks.show', $task) }}"
                                class="text-xs text-indigo-600 hover:text-indigo-800 transition">View →</a>
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