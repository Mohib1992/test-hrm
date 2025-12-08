<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Skill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('skills.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" class="block text-gray-700 text-sm font-bold mb-2">Skill Name</x-input-label>
                            <input 
                                value="{{ old('name') }}" 
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

                        <div class="flex gap-2">
                            <x-secondary-button type="submit">Submit</x-secondary-button>
                            <x-danger-button type="button" onclick="window.location.href='{{ route('skills.index') }}'">Cancel</x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
