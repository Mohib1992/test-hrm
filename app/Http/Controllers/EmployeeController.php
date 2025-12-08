<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $departmentId = $request->get('department_id');
        
        $employees = Employee::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                      ->orWhere('last_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            })
            ->when($departmentId, function ($query, $departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->paginate(10)
            ->appends([
                'search' => $search,
                'department_id' => $departmentId
            ]);
            
        $departments = Department::whereHas('employees')->get();

        return view('employees.index', [
            'employees' => $employees,
            'departments' => $departments,
        ]); 
    }

    public function create(Request $request): View
    {
        $departments = Department::all();
        $skills = Skill::all();

        return view('employees.create', [
            'departments' => $departments,
            'skills' => $skills,
        ]);
    }

    public function findByDepartment(string $departmentId)
    {
        $employees = Employee::where('department_id', $departmentId)->paginate(10);
        $employees->getCollection()->transform(function ($employee) {
            $employee->join_date = $employee->join_date->format('Y-m-d');
            $employee->department = $employee->department->name;
            $employee->edit_url = route('employees.edit', $employee->id);
            $employee->delete_url = route('employees.destroy', $employee->id);
            return $employee;
        }); 
        return response()->json($employees);
    }

    public function store(EmployeeStoreRequest $request): RedirectResponse
    {
        // Check if user already exists with this email
        $user = User::where('email', $request->email)->first();
        
        // If user doesn't exist, create a new one
        if (!$user) {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => bcrypt('password'),
            ]);
        }
        
        // Create employee with validated data and user_id
        $employeeData = array_merge($request->validated(), ['user_id' => $user->id]);
        $employee = Employee::create($employeeData);

        return redirect()->route('employees.index');
    }

    public function edit(Request $request, Employee $employee): View
    {
        $departments = Department::all();
        $skills = Skill::all();

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => $departments,
            'skills' => $skills,
        ]);
    }

    public function show(Employee $employee): View
    {
        return view('employees.show', [
            'employee' => $employee,
        ]);
    }   

    public function update(EmployeeUpdateRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()->route('employees.edit', ['employee' => $employee]);
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
