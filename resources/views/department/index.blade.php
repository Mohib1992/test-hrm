<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Departments') }}
            </h2>
            <x-hyper-button href="{{ route('departments.create') }}">Add Department</x-hyper-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search Bar -->
                    <div class="flex flex-row mb-4">
                        <form method="GET" action="{{ route('departments.index') }}" class="flex gap-2">
                            <div class="relative flex-1">                                
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Search departments by name..." 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                >
                            </div>
                            <x-secondary-button type="submit">Search</x-secondary-button>
                            @if(request('search'))
                                <x-danger-button type="button" onclick="window.location.href='{{ route('departments.index') }}'">Clear</x-danger-button>
                            @endif
                        </form>
                    </div>

                    <table class="w-full text-md shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b hover:bg-orange-100">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Employees</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $department)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $department->name }}</td>
                                <td class="px-4 py-2">{{ Str::limit($department->description, 50) }}</td>
                                <td class="px-4 py-2">{{ $department->employees_count }}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <x-secondary-hyper-button href="{{ route('departments.show', $department->id) }}">Show</x-secondary-hyper-button>
                                    <x-hyper-button href="{{ route('departments.edit', $department->id) }}">Edit</x-hyper-button>
                                    <x-danger-button 
                                        class="delete-department-button" 
                                        data-department-id="{{ $department->id }}"
                                        data-delete-url="{{ route('departments.destroy', $department->id) }}"
                                        x-data="" 
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-department-deletion'); $dispatch('set-delete-data', { id: {{ $department->id }}, url: '{{ route('departments.destroy', $department->id) }}' })"
                                    >Delete</x-danger-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-department-deletion" focusable>
        <form method="post" action="" id="deleteDepartmentForm" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this department?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once the department is deleted, all associated data will be affected.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" type="submit">
                    {{ __('Delete Department') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for the set-delete-data event to update the form action
        window.addEventListener('set-delete-data', function(event) {
            const deleteForm = document.getElementById('deleteDepartmentForm');
            if (deleteForm && event.detail.url) {
                deleteForm.setAttribute('action', event.detail.url);
            }
        });
    });
</script>
