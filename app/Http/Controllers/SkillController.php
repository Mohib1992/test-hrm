<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');
        
        $skills = Skill::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('skill.index', [
            'skills' => $skills,
        ]);
    }

    public function create(Request $request): View
    {
        return view('skill.create');
    }

    public function store(SkillStoreRequest $request): RedirectResponse
    {
        $skill = Skill::create($request->validated());

        $request->session()->flash('skill.id', $skill->id);

        return redirect()->route('skills.index');
    }

    public function show(Request $request, Skill $skill): View
    {
        return view('skill.show', [
            'skill' => $skill,
        ]);
    }

    public function edit(Request $request, Skill $skill): View
    {
        return view('skill.edit', [
            'skill' => $skill,
        ]);
    }

    public function update(SkillUpdateRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        $request->session()->flash('skill.id', $skill->id);

        return redirect()->route('skills.index');
    }

    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('skills.index');
    }
}
