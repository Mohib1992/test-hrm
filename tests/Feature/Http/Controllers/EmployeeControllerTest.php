<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
final class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_responds_with(): void
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk();
        $response->assertJson($employee.index with:employees);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('employees.create'));

        $response->assertOk();
        $response->assertViewIs('employee.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $first_name = fake()->firstName();
        $last_name = fake()->lastName();
        $email = fake()->safeEmail();
        $join_date = Carbon::parse(fake()->date());
        $status = fake()->word();

        $response = $this->post(route('employees.store'), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'join_date' => $join_date,
            'status' => $status,
        ]);

        $employees = Employee::query()
            ->where('first_name', $first_name)
            ->where('last_name', $last_name)
            ->where('email', $email)
            ->where('join_date', $join_date)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $employees);
        $employee = $employees->first();

        $response->assertRedirect(route('employee.index'));
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.edit', $employee));

        $response->assertOk();
        $response->assertViewIs('employee.edit');
        $response->assertViewHas('employees');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $employee = Employee::factory()->create();
        $first_name = fake()->firstName();
        $last_name = fake()->lastName();
        $email = fake()->safeEmail();
        $join_date = Carbon::parse(fake()->date());
        $status = fake()->word();

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'join_date' => $join_date,
            'status' => $status,
        ]);

        $employee->refresh();

        $response->assertRedirect(route('employee.edit', ['employee' => $employee]));

        $this->assertEquals($first_name, $employee->first_name);
        $this->assertEquals($last_name, $employee->last_name);
        $this->assertEquals($email, $employee->email);
        $this->assertEquals($join_date, $employee->join_date);
        $this->assertEquals($status, $employee->status);
    }
}
