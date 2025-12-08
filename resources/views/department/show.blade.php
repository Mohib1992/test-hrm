<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Department Details') }}
            </h2>
            <div class="flex gap-2">
                <x-hyper-button href="{{ route('departments.edit', $department->id) }}">Edit</x-hyper-button>
                <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit">Delete</x-danger-button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Department Information</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                                <p class="font-medium">{{ $department->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Employees</p>
                                <p class="font-medium">{{ $department->employees->count() }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Description</p>
                            <p class="font-medium">{{ $department->description ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Employees in this Department</h3>
                        
                        @if($department->employees->count() > 0)
                            <table class="w-full text-md shadow-md rounded">
                                <thead>
                                    <tr class="border-b hover:bg-orange-100">
                                        <th class="px-4 py-2">#</th>
                                        <th class="px-4 py-2">Name</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Phone</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($department->employees as $employee)
                                    <tr>
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                        <td class="px-4 py-2">{{ $employee->email }}</td>
                                        <td class="px-4 py-2">{{ $employee->phone }}</td>
                                        <td class="px-4 py-2">{{ ucfirst($employee->status) }}</td>
                                        <td class="px-4 py-2">
                                            <x-secondary-hyper-button href="{{ route('employees.show', $employee->id) }}">View</x-secondary-hyper-button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No employees in this department yet.</p>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-secondary-button onclick="window.location.href='{{ route('departments.index') }}'">
                            Back to Departments
                        </x-secondary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
