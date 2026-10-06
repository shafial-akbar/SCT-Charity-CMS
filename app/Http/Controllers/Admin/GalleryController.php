<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query()->with('category')->withCount('photos');

        if ($search = trim((string) $request->input('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                    ->orWhere('title_bn', 'like', "%{$search}%")
                    ->orWhere('slug_en', 'like', "%{$search}%")
                    ->orWhere('slug_bn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $galleries = $query->latest()->paginate(15)->withQueryString();
        $categories = GalleryCategory::query()
            ->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function create()
    {
        $categories = GalleryCategory::query()
            ->where('status', 'active')
            ->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($coverImage = $this->storeCoverImage($request)) {
            $data['cover_image_id'] = $coverImage->id;
        }

        $gallery = Gallery::create($data);

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Gallery created successfully.');
    }

    public function show(Gallery $gallery)
    {
        $gallery->load(['category', 'coverImage', 'photos.media']);
        return view('admin.galleries.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $categories = GalleryCategory::query()
            ->where('status', 'active')
            ->orderBy('sort_order')->orderBy('name_en')->get();

        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $this->validated($request, $gallery);

        if ($request->hasFile('cover_image')) {
            $old = $gallery->coverImage;
            if ($coverImage = $this->storeCoverImage($request)) {
                $data['cover_image_id'] = $coverImage->id;
            }
            $gallery->update($data);
            if ($old) $this->deleteMedia($old);
        } else {
            $gallery->update($data);
        }

        return redirect()->route('admin.galleries.show', $gallery)
            ->with('success', 'Gallery updated successfully.');
    }

    public function removeCover(Gallery $gallery)
    {
        $media = $gallery->coverImage;
        $gallery->update(['cover_image_id' => null]);
        if ($media) $this->deleteMedia($media);

        return back()->with('success', 'Cover image removed successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $cover = $gallery->coverImage;
        $photoMedia = $gallery->photos()->with('media')->get()->pluck('media')->filter();

        $gallery->delete();

        foreach ($photoMedia as $media) $this->deleteMedia($media);
        if ($cover) $this->deleteMedia($cover);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery deleted successfully.');
    }

    private function validated(Request $request, ?Gallery $gallery = null): array
    {
        $id = $gallery?->id;

        return $request->validate([
            'category_id' => [
                'nullable','uuid',
                Rule::exists('gallery_categories', 'id')->where(
                    fn ($q) => $q->where('status', 'active')
                ),
            ],
            'title_en' => ['required','string','max:255'],
            'title_bn' => ['required','string','max:255'],
            'slug_en' => ['required','string','max:255', Rule::unique('galleries','slug_en')->ignore($id)],
            'slug_bn' => ['required','string','max:255', Rule::unique('galleries','slug_bn')->ignore($id)],
            'description_en' => ['nullable','string'],
            'description_bn' => ['nullable','string'],
            'status' => ['required', Rule::in(['draft','published','archived'])],
            'published_at' => ['nullable','date'],
            'cover_image' => ['nullable','image','max:5120'],
        ]);
    }

    private function storeCoverImage(Request $request): ?Media
    {
        if (!$request->hasFile('cover_image')) return null;

        $file = $request->file('cover_image');
        $storedName = Str::random(40).'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('galleries', $storedName, 'public');

        return Media::create([
            'uploaded_by' => auth()->id(),
            'file_name' => $storedName,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);
    }

    private function deleteMedia(Media $media): void
    {
        Storage::disk($media->disk)->delete($media->file_path);
        $media->delete();
    }
}
