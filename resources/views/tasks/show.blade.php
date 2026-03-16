<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class=" flex items-center gap-3 ">
                <a href="javascript:history.back()" class="text-gray-400 hover:text-gray-600 transition">
                    Back
                </a>
            </div>
            @can('update', $task)
            @unless($task->project->archived_at)
            <div class="flex items-center gap-2">
                <a href="{{ route('tasks.edit', $task) }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Edit
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                    onsubmit="return confirm('Delete this task?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Delete
                    </button>
                </form>
            </div>
            @endunless
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
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Task Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Project</dt>
                        <dd class="text-sm font-medium text-gray-900"><a href="{{ route('projects.show', $task->project) }}" class="text-indigo-600 hover:underline">{{ $task->project->name }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Description</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $task->description }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Status</dt>
                        <dd>
                            @if($task->status === 'completed')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span>
                            @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">In Progress</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Due Date</dt>
                        <dd class="text-sm text-gray-700">{{ $task->due_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 mb-1">Total Logged</dt>
                        <dd class="text-sm text-gray-700">{{ $task->timelogs->sum('minutes') }} mins</dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-gray-700">
                        Time Logs ({{ $task->timelogs->count() }})
                    </h3>
                    @can('create', App\Models\Timelog::class)
                    @unless($task->project->archived_at)
                    <a href="{{ route('timelogs.create', ['task' => $task->id]) }}"
                        class="text-xs bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg transition">
                        + Log Time
                    </a>
                    @endunless
                    @endcan
                </div>
                @forelse($task->timelogs as $timelog)
                <div class="px-6 py-4 border-b border-gray-50 last:border-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $timelog->minutes }} mins
                                <span class="text-gray-400 font-normal">by {{ $timelog->user->name }}</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $timelog->note }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $timelog->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        @can('update', $timelog)
                        @unless($task->project->archived_at)
                        <div class="flex items-center gap-3 ml-4">
                            <a href="{{ route('timelogs.edit', $timelog) }}"
                                class="text-xs text-gray-500 hover:text-indigo-600 transition">Edit</a>
                            <form action="{{ route('timelogs.destroy', $timelog) }}" method="POST"
                                onsubmit="return confirm('Delete this time log?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs text-gray-500 hover:text-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endunless
                        @endcan
                    </div>
                </div>
                @empty
                <div class="px-6 py-10 text-center text-sm text-gray-400">
                    No time logged yet.
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>