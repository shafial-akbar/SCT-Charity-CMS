<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GalleryCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryCategory::query()->withCount('galleries');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en','like',"%{$search}%")
                    ->orWhere('name_bn','like',"%{$search}%")
                    ->orWhere('slug_en','like',"%{$search}%")
                    ->orWhere('slug_bn','like',"%{$search}%");
            });
        }

        if ($request->filled('status')) $query->where('status', $request->input('status'));

        $categories = $query->orderBy('sort_order')->orderByDesc('created_at')
            ->paginate(15)->withQueryString();

        return view('admin.gallery-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.gallery-categories.create');
    }

    public function store(Request $request)
    {
        GalleryCategory::create($this->validated($request));
        return redirect()->route('admin.gallery-categories.index')
            ->with('success','Gallery category created successfully.');
    }

    public function edit(GalleryCategory $galleryCategory)
    {
        return view('admin.gallery-categories.edit', compact('galleryCategory'));
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        $galleryCategory->update($this->validated($request, $galleryCategory));
        return redirect()->route('admin.gallery-categories.index')
            ->with('success','Gallery category updated successfully.');
    }

    public function destroy(GalleryCategory $galleryCategory)
    {
        if ($galleryCategory->galleries()->exists()) {
            return back()->with('error','This category cannot be deleted because galleries are using it.');
        }

        $galleryCategory->delete();
        return redirect()->route('admin.gallery-categories.index')
            ->with('success','Gallery category deleted successfully.');
    }

    private function validated(Request $request, ?GalleryCategory $category = null): array
    {
        $id = $category?->id;

        return $request->validate([
            'name_en' => ['required','string','max:255'],
            'name_bn' => ['required','string','max:255'],
            'slug_en' => ['required','string','max:255', Rule::unique('gallery_categories','slug_en')->ignore($id)],
            'slug_bn' => ['required','string','max:255', Rule::unique('gallery_categories','slug_bn')->ignore($id)],
            'description_en' => ['nullable','string'],
            'description_bn' => ['nullable','string'],
            'sort_order' => ['required','integer','min:0','max:999999'],
            'status' => ['required',Rule::in(['active','inactive'])],
        ]);
    }
}
