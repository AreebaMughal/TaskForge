<div>
    <!-- Be present above all else. - Naval Ravikant -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center gap-1 text-xl font-semibold text-gray-100 transition focus:outline-none">
                        <div class="ms-1">
                            <svg class="fill-current h-7 w-7 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('projects.index')">
                        Projects
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('clients.index')">
                        Clients
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            @can('create', App\Models\Client::class)
            <a href="{{ route('clients.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Add New Client
            </a>
            @endcan
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash messages --}}
            @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
            @endif
            {{-- Table --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Projects</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $client->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $client->email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $client->projects_count }} projects
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $client->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-left text-sm space-x-3">
                                <a href="{{ route('clients.show', $client) }}"
                                    class="text-gray-500 hover:text-indigo-600 transition">View</a>
                                @can('update', $client)
                                <a href="{{ route('clients.edit', $client) }}"
                                    class="text-gray-500 hover:text-indigo-600 transition px-5">Edit</a>
                                @endcan
                                @can('delete', $client)
                                <form action="{{ route('clients.destroy', $client) }}"
                                    method="POST" class="inline"
                                    onsubmit="return confirm('Delete this client?')">
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
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">
                                No clients found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($clients->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $clients->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>