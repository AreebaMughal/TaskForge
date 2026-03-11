<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="javascript:history.back()" class="text-gray-400 hover:text-gray-600 transition">
                Back
            </a>
        </div>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('timelogs.update', $timelog) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="minutes" class="block text-sm font-medium text-gray-700 mb-1">
                            Minutes <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="minutes" name="minutes"
                               value="{{ old('minutes', $timelog->minutes) }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      @error('minutes') border-red-400 @enderror">
                        @error('minutes')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                            Note <span class="text-red-500">*</span>
                        </label>
                        <textarea id="note" name="note" rows="3"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                      @error('note') border-red-400 @enderror">{{old('note', $timelog->note)}}</textarea>
                        @error('note')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
                            Create Log Time
                        </button>
                        <a href="javascript:history.back()"
                           class="text-sm text-gray-500 hover:text-gray-700 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>