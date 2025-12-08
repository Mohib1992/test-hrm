<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Department') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</x-input-label>
                            <input 
                                value="{{ old('name', $department->name) }}" 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required
                            >
                            @error('name')
                                <x-input-error :messages="$errors->get('name')" />
                            @enderror
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</x-input-label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="4"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            >{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <x-input-error :messages="$errors->get('description')" />
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <x-secondary-button type="submit">Update</x-secondary-button>
                            <x-danger-button type="button" onclick="window.location.href='{{ route('departments.index') }}'">Cancel</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
