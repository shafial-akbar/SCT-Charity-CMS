<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectActivityController extends Controller
{
    public function index(Request $request): View
    {
        $activities = ProjectActivity::query()
            ->with('project')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search')->toString();

                $q->where(function ($q) use ($search) {
                    $q->where('title_en', 'like', "%{$search}%")
                        ->orWhere('title_bn', 'like', "%{$search}%")
                        ->orWhere('location_en', 'like', "%{$search}%")
                        ->orWhere('location_bn', 'like', "%{$search}%")
                        ->orWhereHas('project', function ($q) use ($search) {
                            $q->where('title_en', 'like', "%{$search}%")
                                ->orWhere('title_bn', 'like', "%{$search}%")
                                ->orWhere('slug_en', 'like', "%{$search}%")
                                ->orWhere('slug_bn', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('project_id'), fn ($q) => $q->where('project_id', $request->string('project_id')->toString()))
            ->orderBy('activity_date')
            ->orderBy('sort_order')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $projects = Project::query()
            ->orderBy('title_en')
            ->get(['id', 'title_en', 'title_bn']);

        return view('admin.project-activities.index', compact('activities', 'projects'));
    }

    public function create(): View
    {
        $projects = Project::query()
            ->orderBy('title_en')
            ->get(['id', 'title_en', 'title_bn']);

        return view('admin.project-activities.create', compact('projects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        ProjectActivity::create($data);

        return redirect()
            ->route('admin.project-activities.index')
            ->with('success', 'Project activity created successfully.');
    }

    public function show(ProjectActivity $projectActivity): View
    {
        $projectActivity->load('project');

        return view('admin.project-activities.show', compact('projectActivity'));
    }

    public function edit(ProjectActivity $projectActivity): View
    {
        $projectActivity->load('project');

        $projects = Project::query()
            ->orderBy('title_en')
            ->get(['id', 'title_en', 'title_bn']);

        return view('admin.project-activities.edit', compact('projectActivity', 'projects'));
    }

    public function update(Request $request, ProjectActivity $projectActivity): RedirectResponse
    {
        $data = $this->validated($request, $projectActivity);

        $projectActivity->update($data);

        return redirect()
            ->route('admin.project-activities.index')
            ->with('success', 'Project activity updated successfully.');
    }

    public function destroy(ProjectActivity $projectActivity): RedirectResponse
    {
        $projectActivity->delete();

        return redirect()
            ->route('admin.project-activities.index')
            ->with('success', 'Project activity deleted successfully.');
    }

    private function validated(Request $request, ?ProjectActivity $projectActivity = null): array
    {
        return $request->validate([
            'project_id' => ['required', 'uuid', 'exists:projects,id'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_bn' => ['required', 'string', 'max:255'],
            'description_en' => ['nullable', 'string'],
            'description_bn' => ['nullable', 'string'],
            'activity_date' => ['nullable', 'date'],
            'location_en' => ['nullable', 'string', 'max:255'],
            'location_bn' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['planned', 'completed', 'cancelled'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
        ]);
    }
}
