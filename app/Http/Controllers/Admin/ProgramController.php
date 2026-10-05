<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function index(Request $request): View
    {
        $programs = Program::query()
            ->with('featuredImage')
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search')->toString();
                $q->where(function ($q) use ($search) {
                    $q->where('title_en', 'like', "%{$search}%")
                        ->orWhere('title_bn', 'like', "%{$search}%")
                        ->orWhere('slug_en', 'like', "%{$search}%")
                        ->orWhere('slug_bn', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.programs.index', compact('programs'));
    }

    public function create(): View
    {
        $media = Media::query()->latest()->get();
        return view('admin.programs.create', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if (blank($data['slug_en'])) {
            $data['slug_en'] = Str::slug($data['title_en']);
        }

        if (blank($data['slug_bn'])) {
            $data['slug_bn'] = $data['title_bn'] ?: $data['slug_en'];
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    public function edit(Program $program): View
    {
        $media = Media::query()->latest()->get();
        $program->load('featuredImage');

        return view('admin.programs.edit', compact('program', 'media'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $this->validated($request, $program);

        if (blank($data['slug_en'])) {
            $data['slug_en'] = Str::slug($data['title_en']);
        }

        if (blank($data['slug_bn'])) {
            $data['slug_bn'] = $data['title_bn'] ?: $data['slug_en'];
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    private function validated(Request $request, ?Program $program = null): array
    {
        $enSlugRule = Rule::unique('programs', 'slug_en');
        $bnSlugRule = Rule::unique('programs', 'slug_bn');

        if ($program) {
            $enSlugRule->ignore($program->id);
            $bnSlugRule->ignore($program->id);
        }

        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_bn' => ['required', 'string', 'max:255'],
            'slug_en' => ['nullable', 'string', 'max:255', $enSlugRule],
            'slug_bn' => ['nullable', 'string', 'max:255', $bnSlugRule],
            'short_description_en' => ['nullable', 'string'],
            'short_description_bn' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'description_bn' => ['nullable', 'string'],
            'featured_image_id' => ['nullable', 'uuid', 'exists:media,id'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'seo_title_en' => ['nullable', 'string', 'max:255'],
            'seo_title_bn' => ['nullable', 'string', 'max:255'],
            'seo_description_en' => ['nullable', 'string'],
            'seo_description_bn' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
