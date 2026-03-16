<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="javascript:history.back()" class="text-gray-400 hover:text-gray-600 transition">Back</a>
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
                    <div x-data="{
                        open: false,
                        selected: {{ json_encode(old('members', $project->members->pluck('id')->toArray())) }},
                        users: {{ json_encode($users->map(fn($u) => ['id' => $u->id, 'name' => $u->name])) }},
                        get selectedNames() {
                            if (this.selected.length === 0) return 'Select Members';
                            return this.users
                                .filter(u => this.selected.includes(u.id))
                                .map(u => u.name)
                                .join(', ');
                        },
                        toggle(id) {
                            if (this.selected.includes(id)) {
                                this.selected = this.selected.filter(item => item !== id);
                            } else {
                                this.selected.push(id);
                            }
                        }
                    }" class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Assign Members
                        </label>
                        
                        <button type="button" @click="open = !open" 
                            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm text-left
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500 flex items-center justify-between">
                            <span class="truncate" x-text="selectedNames"></span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg py-1 max-h-60 overflow-auto">
                            <template x-for="user in users" :key="user.id">
                                <div @click="toggle(user.id)" 
                                    class="px-4 py-2 text-sm cursor-pointer hover:bg-indigo-50 flex items-center gap-2"
                                    :class="selected.includes(user.id) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700'">
                                    <input type="checkbox" :checked="selected.includes(user.id)" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span x-text="user.name"></span>
                                </div>
                            </template>
                        </div>

                        <!-- Hidden inputs for form submission -->
                        <template x-for="id in selected" :key="'member-' + id">
                            <input type="hidden" name="members[]" :value="id">
                        </template>

                        @error('members')
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