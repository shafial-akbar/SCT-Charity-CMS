<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryPhotoController extends Controller
{
    public function index(Request $request): View
    {
        $photos = GalleryPhoto::query()
            ->with(['gallery', 'media'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search')->toString();
                $q->where(function ($q) use ($search) {
                    $q->where('caption_en', 'like', "%{$search}%")
                        ->orWhere('caption_bn', 'like', "%{$search}%")
                        ->orWhere('alt_text_en', 'like', "%{$search}%")
                        ->orWhere('alt_text_bn', 'like', "%{$search}%")
                        ->orWhereHas('gallery', function ($g) use ($search) {
                            $g->where('title_en', 'like', "%{$search}%")
                                ->orWhere('title_bn', 'like', "%{$search}%")
                                ->orWhere('slug_en', 'like', "%{$search}%")
                                ->orWhere('slug_bn', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('gallery_id'), fn ($q) => $q->where('gallery_id', $request->string('gallery_id')->toString()))
            ->orderBy('sort_order')
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        $galleries = Gallery::query()
            ->orderBy('title_en')
            ->get(['id', 'title_en', 'title_bn']);

        return view('admin.gallery-photos.index', compact('photos', 'galleries'));
    }

    public function create(): View
    {
        $galleries = Gallery::query()->orderBy('title_en')->get(['id', 'title_en', 'title_bn']);
        $media = Media::query()->latest()->get();

        return view('admin.gallery-photos.create', compact('galleries', 'media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['media_id'] = $this->uploadPhoto($request->file('photo'))->id;
        }

        unset($data['photo']);

        GalleryPhoto::create($data);

        return redirect()
            ->route('admin.gallery-photos.index')
            ->with('success', 'Gallery photo created successfully.');
    }

    public function show(GalleryPhoto $galleryPhoto): View
    {
        $galleryPhoto->load(['gallery', 'media']);

        return view('admin.gallery-photos.show', compact('galleryPhoto'));
    }

    public function edit(GalleryPhoto $galleryPhoto): View
    {
        $galleryPhoto->load(['gallery', 'media']);
        $galleries = Gallery::query()->orderBy('title_en')->get(['id', 'title_en', 'title_bn']);
        $media = Media::query()->latest()->get();

        return view('admin.gallery-photos.edit', compact('galleryPhoto', 'galleries', 'media'));
    }

    public function update(Request $request, GalleryPhoto $galleryPhoto): RedirectResponse
    {
        $data = $this->validated($request, true);
        $oldMedia = $galleryPhoto->media;

        if ($request->hasFile('photo')) {
            $data['media_id'] = $this->uploadPhoto($request->file('photo'))->id;
        } elseif ($request->boolean('remove_photo')) {
            $data['media_id'] = null;
        }

        unset($data['photo'], $data['remove_photo']);

        $galleryPhoto->update($data);

        if ($oldMedia && ($request->hasFile('photo') || $request->boolean('remove_photo'))) {
            $this->deleteMedia($oldMedia);
        }

        return redirect()
            ->route('admin.gallery-photos.index')
            ->with('success', 'Gallery photo updated successfully.');
    }

    public function destroy(GalleryPhoto $galleryPhoto): RedirectResponse
    {
        $galleryPhoto->load('media');
        $media = $galleryPhoto->media;
        $galleryPhoto->delete();

        if ($media) {
            $this->deleteMedia($media);
        }

        return redirect()
            ->route('admin.gallery-photos.index')
            ->with('success', 'Gallery photo deleted successfully.');
    }

    private function validated(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'gallery_id' => ['required', 'uuid', 'exists:galleries,id'],
            'media_id' => ['nullable', 'uuid', 'exists:media,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', $isUpdate ? 'sometimes' : 'required_without:media_id'],
            'remove_photo' => ['nullable', 'boolean'],
            'caption_en' => ['nullable', 'string'],
            'caption_bn' => ['nullable', 'string'],
            'alt_text_en' => ['nullable', 'string', 'max:255'],
            'alt_text_bn' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uploadPhoto($file): Media
    {
        $path = $file->store('gallery-photos', 'public');

        return Media::create([
            'uploaded_by' => auth()->id(),
            'file_name' => basename($path),
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'alt_text_en' => null,
            'alt_text_bn' => null,
            'title_en' => null,
            'title_bn' => null,
            'caption_en' => null,
            'caption_bn' => null,
            'metadata' => [
                'module' => 'gallery_photos',
                'uploaded_via' => 'gallery_photo',
            ],
        ]);
    }

    private function deleteMedia(Media $media): void
    {
        if ($media->file_path && Storage::disk($media->disk)->exists($media->file_path)) {
            Storage::disk($media->disk)->delete($media->file_path);
        }

        $media->delete();
    }
}
