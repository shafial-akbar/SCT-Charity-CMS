<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::with('parent')->orderBy('sort_order')->orderBy('title_en')->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $parents = Page::orderBy('title_en')->get();
        return view('admin.pages.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title_en']);
        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): View
    {
        $parents = Page::whereKeyNot($page->id)->orderBy('title_en')->get();
        $page->load(['sections' => fn ($q) => $q->orderBy('sort_order')]);
        return view('admin.pages.edit', compact('page', 'parents'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $this->validated($request, $page);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title_en']);
        $page->update($data);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }

    private function validated(Request $request, ?Page $page = null): array
    {
        return $request->validate([
            'parent_id' => ['nullable', 'uuid', 'exists:pages,id'],
            'title_en' => ['required', 'string', 'max:255'],
            'title_bn' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page?->id)],
            'page_type' => ['required', 'string', 'max:50'],
            'short_description_en' => ['nullable', 'string'],
            'short_description_bn' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'seo_title_en' => ['nullable', 'string', 'max:255'],
            'seo_title_bn' => ['nullable', 'string', 'max:255'],
            'seo_description_en' => ['nullable', 'string'],
            'seo_description_bn' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
