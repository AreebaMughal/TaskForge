<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                Back
            </a>
            <h2 class="text-xl font-semibold text-gray-800">New User</h2>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            User Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      @error('name') border-red-400 @enderror">
                        @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Contact Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      @error('email') border-red-400 @enderror">
                        @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      @error('password') border-red-400 @enderror">
                        @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role" name="role"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       @error('role') border-red-400 @enderror">
                            <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                            Create User
                        </button>
                        <a href="{{ route('users.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>