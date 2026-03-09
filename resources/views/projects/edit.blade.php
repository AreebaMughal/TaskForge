<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-gray-600 transition">Back</a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Project Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', $project->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                                      @error('name') border-red-400 @enderror">
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <select id="client_id" name="client_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       @error('client_id') border-red-400 @enderror">
                            @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('client_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $project->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500
                                          @error('start_date') border-red-400 @enderror">
                            @error('start_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Due Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="due_date" name="due_date"
                                value="{{ old('due_date', $project->due_date->format('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500
                                          @error('due_date') border-red-400 @enderror">
                            @error('due_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                            Save Changes
                        </button>
                        <a href="{{ route('projects.show', $project) }}"
                            class="text-sm text-gray-500 hover:text-gray-700 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>