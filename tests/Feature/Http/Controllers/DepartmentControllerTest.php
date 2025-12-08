<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DepartmentController
 */
final class DepartmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $departments = Department::factory()->count(3)->create();

        $response = $this->get(route('departments.index'));

        $response->assertOk();
        $response->assertViewIs('department.index');
        $response->assertViewHas('departments', $departments);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('departments.create'));

        $response->assertOk();
        $response->assertViewIs('department.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartmentController::class,
            'store',
            \App\Http\Requests\DepartmentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();
        $employee = Employee::factory()->create();

        $response = $this->post(route('departments.store'), [
            'name' => $name,
            'employee_id' => $employee->id,
        ]);

        $departments = Department::query()
            ->where('name', $name)
            ->where('employee_id', $employee->id)
            ->get();
        $this->assertCount(1, $departments);
        $department = $departments->first();

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('department.id', $department->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $department = Department::factory()->create();

        $response = $this->get(route('departments.show', $department));

        $response->assertOk();
        $response->assertViewIs('department.show');
        $response->assertViewHas('department', $department);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $department = Department::factory()->create();

        $response = $this->get(route('departments.edit', $department));

        $response->assertOk();
        $response->assertViewIs('department.edit');
        $response->assertViewHas('department', $department);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DepartmentController::class,
            'update',
            \App\Http\Requests\DepartmentUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $department = Department::factory()->create();
        $name = fake()->name();
        $employee = Employee::factory()->create();

        $response = $this->put(route('departments.update', $department), [
            'name' => $name,
            'employee_id' => $employee->id,
        ]);

        $department->refresh();

        $response->assertRedirect(route('departments.index'));
        $response->assertSessionHas('department.id', $department->id);

        $this->assertEquals($name, $department->name);
        $this->assertEquals($employee->id, $department->employee_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $department = Department::factory()->create();

        $response = $this->delete(route('departments.destroy', $department));

        $response->assertRedirect(route('departments.index'));

        $this->assertModelMissing($department);
    }
}
