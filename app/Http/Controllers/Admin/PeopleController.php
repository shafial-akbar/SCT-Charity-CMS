<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PeopleController extends Controller
{
    public function index(Request $request): View
    {
        $people = Person::query()
            ->with('photo')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('designation_en', 'like', "%{$search}%")
                        ->orWhere('designation_bn', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.people.index', compact('people'));
    }

    public function create(): View
    {
        $media = Media::query()->latest('created_at')->get();

        return view('admin.people.create', compact('media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['social_links'] = $this->decodeSocialLinks($validated['social_links'] ?? null);

        if ($request->hasFile('featured_image')) {
            $validated['photo_id'] = $this->uploadPhoto($request->file('featured_image'))->id;
        }

        unset($validated['featured_image'], $validated['remove_featured_image']);

        Person::create($validated);

        return redirect()
            ->route('admin.people.index')
            ->with('success', 'Person created successfully.');
    }

    public function show(Person $person): View
    {
        $person->load('photo');

        return view('admin.people.show', compact('person'));
    }

    public function edit(Person $person): View
    {
        $person->load('photo');
        $media = Media::query()->latest('created_at')->get();

        return view('admin.people.edit', compact('person', 'media'));
    }

    public function update(Request $request, Person $person): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['social_links'] = $this->decodeSocialLinks($validated['social_links'] ?? null);

        $oldPhoto = $person->photo;

        if ($request->boolean('remove_featured_image')) {
            $validated['photo_id'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $validated['photo_id'] = $this->uploadPhoto($request->file('featured_image'))->id;
        }

        unset($validated['featured_image'], $validated['remove_featured_image']);

        $person->update($validated);

        if (
            $oldPhoto &&
            ($request->hasFile('featured_image') || $request->boolean('remove_featured_image'))
        ) {
            $this->deleteMedia($oldPhoto);
        }

        return redirect()
            ->route('admin.people.index')
            ->with('success', 'Person updated successfully.');
    }

    public function destroy(Person $person): RedirectResponse
    {
        $person->load('photo');

        $photo = $person->photo;

        $person->delete();

        if ($photo) {
            $this->deleteMedia($photo);
        }

        return redirect()
            ->route('admin.people.index')
            ->with('success', 'Person deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation_en' => ['nullable', 'string', 'max:255'],
            'designation_bn' => ['nullable', 'string', 'max:255'],
            'biography_en' => ['nullable', 'string'],
            'biography_bn' => ['nullable', 'string'],
            'message_en' => ['nullable', 'string'],
            'message_bn' => ['nullable', 'string'],
            'photo_id' => ['nullable', 'uuid', 'exists:media,id'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_featured_image' => ['nullable', 'boolean'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'social_links' => ['nullable', 'json'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);
    }

    private function decodeSocialLinks(?string $value): ?array
    {
        if (blank($value)) {
            return null;
        }

        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }

    private function uploadPhoto($file): Media
    {
        $path = $file->store('people', 'public');

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
                'module' => 'people',
                'uploaded_via' => 'person_photo',
            ],
        ]);
    }

    private function deleteMedia(Media $media): void
    {
        if (
            $media->file_path &&
            Storage::disk($media->disk)->exists($media->file_path)
        ) {
            Storage::disk($media->disk)->delete($media->file_path);
        }

        $media->delete();
    }
}
