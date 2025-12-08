<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">                                  
                        <form action="{{ route('employees.update', $employee) }}" method="PUT">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <x-input-label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">First Name</x-input-label>
                                <input value="{{ $employee->first_name }}" type="text" name="first_name" id="first_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('first_name')
                                    <x-input-error :messages="$errors->get('first_name')" />
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-input-label for="last_name" class="block text-gray-700 text-sm font-bold mb-2">Last Name</x-input-label>
                                <input value="{{ $employee->last_name }}" type="text" name="last_name" id="last_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                @error('last_name')
                                    <x-input-error :messages="$errors->get('last_name')" /> 
                                @enderror
                            </div>
                            <div class="mb-4">  
                                <x-input-label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</x-input-label>
                                <input value="{{ $employee->phone }}" type="text" name="phone" id="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @error('phone')
                                    <x-input-error :messages="$errors->get('phone')" />
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-input-label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</x-input-label>
                                <input type="email" value="{{ $employee->email }}" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                @error('email')
                                    <x-input-error :messages="$errors->get('email')" />
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-input-label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department</x-input-label>
                                <select name="department_id" id="department_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if($employee->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <x-input-error :messages="$errors->get('department_id')" />
                                @enderror
                            </div>
                            <div class="mb-4">
                                <x-input-label for="join_date" class="block text-gray-700 text-sm font-bold mb-2">Join Date</x-input-label>
                                <input type="date" value="{{ $employee->join_date }}" name="join_date" id="join_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                @error('join_date')
                                    <x-input-error :messages="$errors->get('join_date')" />
                                @enderror
                            </div>
                            <div class="mb-4">
                              <div class="msa-wrapper" x-data="multiselectComponent()" x-init="$watch('selected', value => selectedString = value.join(','))">
  <x-input-label for="skills" class="block text-gray-700 text-sm font-bold mb-2">Skills</x-input-label>
  <input 
         x-model="selectedString" 
         type="text" 
         name="skills"
         id="skills" 
         aria-hidden="true" 
         x-bind:aria-expanded="listActive.toString()" 
         aria-haspopup="tag-list"
         hidden>    
            <div class="input-presentation" @click="listActive = !listActive" @click.away="listActive = false" x-bind:class="{'active': listActive}">
                <span class="placeholder" x-show="selected.length == 0">Select Skills</span>
                <template x-for="(tag, index) in selected">
                <div class="tag-badge">
                    <span x-text="tag"></span>
                    <button x-bind:data-index="index" @click.stop="removeMe($event)">x</button>
                </div>
                </template>
            </div>
            <ul id="tag-list" x-show.transition="listActive" role="listbox">
                <template x-for="(tag, index, collection) in unselected">
                <li x-show="!selected.includes(tag)" 
                    x-bind:value="tag" 
                    x-text="tag" 
                    aria-role="button" 
                    @click.stop="addMe($event)" 
                    x-bind:data-index="index"
                    role="option"
                ></li>
                </template>
            </ul>
            </div>
                            </div>  
                            <div class="mb-4">
                                <x-input-label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</x-input-label>
                                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                                    <option value="" selected>Select Status</option>
                                    <option value="active" @if($employee->status == 'active') selected @endif>Active</option>
                                    <option value="inactive" @if($employee->status == 'inactive') selected @endif>Inactive</option>
                                    <option value="terminated" @if($employee->status == 'terminated') selected @endif>Terminated</option>
                                </select>
                                @error('status')
                                    <x-input-error :messages="$errors->get('status')" />
                                @enderror
                            </div>
                            <x-secondary-button type="submit">Submit</x-secondary-button>
                            <x-danger-button type="reset">Cancel</x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<style>
.msa-wrapper {
    position: relative;
    width: 100%;
}

.input-presentation {
    min-height: 42px;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    background-color: white;
    cursor: pointer;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
}

.input-presentation.active {
    border-color: #6366f1;
    outline: 2px solid #6366f1;
    outline-offset: 2px;
}

.placeholder {
    color: #9ca3af;
    font-size: 0.875rem;
}

.tag-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background-color: #3b82f6;
    color: white;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}

.tag-badge button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-weight: bold;
    padding: 0 4px;
    font-size: 1rem;
}

.tag-badge button:hover {
    color: #fee2e2;
}

#tag-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    margin-top: 4px;
    background-color: white;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    max-height: 200px;
    overflow-y: auto;
    z-index: 50;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

#tag-list li {
    padding: 8px 12px;
    cursor: pointer;
    color: #374151;
}

#tag-list li:hover {
    background-color: #f3f4f6;
}
</style>

<script>
function multiselectComponent() {
  const employeeSkills = @json($employee->skills->pluck('name')->toArray());
  const allSkills = @json($skills->pluck('name')->toArray());
  
  return {
    listActive: false,
    selectedString: employeeSkills.join(','),
    selected: employeeSkills,
    unselected: allSkills.filter(skill => !employeeSkills.includes(skill)),
    addMe(e) {
      const index = e.target.dataset.index;
      const extracted = this.unselected.splice(index, 1);
      this.selected.push(extracted[0]);
    },
    removeMe(e) {
      const index = e.target.dataset.index;
      const extracted = this.selected.splice(index, 1);
      this.unselected.push(extracted[0]);
    }
  };
}
</script>
</x-app-layout>
