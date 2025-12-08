<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SkillController
 */
final class SkillControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $skills = Skill::factory()->count(3)->create();

        $response = $this->get(route('skills.index'));

        $response->assertOk();
        $response->assertViewIs('skill.index');
        $response->assertViewHas('skills', $skills);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('skills.create'));

        $response->assertOk();
        $response->assertViewIs('skill.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SkillController::class,
            'store',
            \App\Http\Requests\SkillStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();

        $response = $this->post(route('skills.store'), [
            'name' => $name,
        ]);

        $skills = Skill::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $skills);
        $skill = $skills->first();

        $response->assertRedirect(route('skills.index'));
        $response->assertSessionHas('skill.id', $skill->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->get(route('skills.show', $skill));

        $response->assertOk();
        $response->assertViewIs('skill.show');
        $response->assertViewHas('skill', $skill);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->get(route('skills.edit', $skill));

        $response->assertOk();
        $response->assertViewIs('skill.edit');
        $response->assertViewHas('skill', $skill);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SkillController::class,
            'update',
            \App\Http\Requests\SkillUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $skill = Skill::factory()->create();
        $name = fake()->name();

        $response = $this->put(route('skills.update', $skill), [
            'name' => $name,
        ]);

        $skill->refresh();

        $response->assertRedirect(route('skills.index'));
        $response->assertSessionHas('skill.id', $skill->id);

        $this->assertEquals($name, $skill->name);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->delete(route('skills.destroy', $skill));

        $response->assertRedirect(route('skills.index'));

        $this->assertSoftDeleted($skill);
    }
}
