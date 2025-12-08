<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>
        <x-hyper-button href="{{ route('employees.create') }}">Add Employee</x-hyper-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search Bar -->             
                    <div class="mb-4">
                        <div class="flex flex-row">
                              <select name="department_id" id="department_id" 
                        class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                            <form method="GET" action="{{ route('employees.index') }}" class="flex gap-2">
                            <div class="relative flex-1">                         
                                <input 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Search by name, email, or phone..."
                                />
                            </div>
                            <x-secondary-button type="submit">Search</x-secondary-button>
                            @if(request('search'))
                                <x-danger-button type="button" onclick="window.location.href='{{ route('employees.index') }}'">Clear</x-danger-button>
                            @endif
                        </form>
                        </div>
                    </div>
                    <table id="employeeTable" class="w-full text-md shadow-md rounded mb-4">
                        <thead>
                            <tr class="border-b hover:bg-orange-100">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Department</th>
                                <th class="px-4 py-2">Join Date</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td class="px-4 py-2">{{ $employee->phone }}</td>
                                <td class="px-4 py-2">{{ $employee->email }}</td>
                                <td class="px-4 py-2">{{ $employee->department->name }}</td>
                                <td class="px-4 py-2">{{ $employee->join_date->toDateString() }}</td>
                                <td class="px-4 py-2">{{ $employee->status}}</td>
                                <td class="px-4 py-2 flex gap-2">
                                    <x-secondary-hyper-button href="{{ route('employees.show', $employee->id) }}">Show</x-secondary-hyper-button>
                                    <x-hyper-button href="{{ route('employees.edit', $employee->id) }}">Edit</x-hyper-button>
                                    <x-danger-button 
                                        class="delete-employee-button" 
                                        data-employee-id="{{ $employee->id }}"
                                        data-delete-url="{{ route('employees.destroy', $employee->id) }}"
                                        x-data="" 
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-employee-deletion'); $dispatch('set-delete-data', { id: {{ $employee->id }}, url: '{{ route('employees.destroy', $employee->id) }}' })"
                                    >Delete</x-danger-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $employees->links()  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal name="confirm-employee-deletion" focusable>
        <form method="post" action="" id="deleteEmployeeForm" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this employee?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once the employee is deleted, all of their data will be permanently removed from the system.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" type="submit">
                    {{ __('Delete Employee') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>  
</x-app-layout>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department_id');
    
    // Set the selected department from URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const departmentId = urlParams.get('department_id');
    if (departmentId) {
        departmentSelect.value = departmentId;
    }
    
    // When department changes, reload page with department parameter
    departmentSelect.addEventListener('change', function() {
        const selectedDepartment = this.value;
        const currentUrl = new URL(window.location.href);
        
        if (selectedDepartment) {
            currentUrl.searchParams.set('department_id', selectedDepartment);
        } else {
            currentUrl.searchParams.delete('department_id');
        }
        
        // Remove page parameter to start from page 1
        currentUrl.searchParams.delete('page');
        
        window.location.href = currentUrl.toString();
    });

    // Listen for the set-delete-data event to update the form action
    window.addEventListener('set-delete-data', function(event) {
        const deleteForm = document.getElementById('deleteEmployeeForm');
        if (deleteForm && event.detail.url) {
            deleteForm.setAttribute('action', event.detail.url);
        }
    }); 
}); 
</script>
