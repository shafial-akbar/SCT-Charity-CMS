<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageSectionController extends Controller
{
    public function create(Page $page): View
    {
        $types = config('page_sections.types', []);
        return view('admin.page_sections.create', compact('page', 'types'));
    }

    public function store(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validated($request);
        $data['page_id'] = $page->id;
        $data['data'] = $this->jsonData($request->input('data'));

        PageSection::create($data);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page section created successfully.');
    }

    public function edit(Page $page, PageSection $section): View
    {
        abort_unless($section->page_id === $page->id, 404);
        $types = config('page_sections.types', []);
        return view('admin.page_sections.edit', compact('page', 'section', 'types'));
    }

    public function update(Request $request, Page $page, PageSection $section): RedirectResponse
    {
        abort_unless($section->page_id === $page->id, 404);

        $data = $this->validated($request);
        $data['data'] = $this->jsonData($request->input('data'));
        $section->update($data);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page section updated successfully.');
    }

    public function destroy(Page $page, PageSection $section): RedirectResponse
    {
        abort_unless($section->page_id === $page->id, 404);
        $section->delete();

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page section deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'section_type' => ['required', 'string', 'max:100'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'subtitle_bn' => ['nullable', 'string', 'max:255'],
            'content_en' => ['nullable', 'string'],
            'content_bn' => ['nullable', 'string'],
            'media_id' => ['nullable', 'uuid', 'exists:media,id'],
            'data' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);
    }

    private function jsonData(?string $value): ?array
    {
        if (blank($value)) return null;

        $decoded = json_decode($value, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            abort(422, 'Section data must contain valid JSON.');
        }

        return $decoded;
    }
}
