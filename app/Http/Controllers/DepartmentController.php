<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');
        
        $departments = Department::withCount('employees')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('department.index', [
            'departments' => $departments,
        ]);
    }

    public function create(Request $request): View
    {
        return view('department.create');
    }

    public function store(DepartmentStoreRequest $request): RedirectResponse
    {
        $department = Department::create($request->validated());

        $request->session()->flash('department.id', $department->id);

        return redirect()->route('departments.index');
    }

    public function show(Request $request, Department $department): View
    {
        return view('department.show', [
            'department' => $department,
        ]);
    }

    public function edit(Request $request, Department $department): View
    {
        return view('department.edit', [
            'department' => $department,
        ]);
    }

    public function update(DepartmentUpdateRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        $request->session()->flash('department.id', $department->id);

        return redirect()->route('departments.index');
    }

    public function destroy(Request $request, Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('departments.index');
    }
}
