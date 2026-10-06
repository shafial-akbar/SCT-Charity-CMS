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
    /**
     * Display all programs.
     */
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
            ->when(
                $request->filled('status'),
                fn ($q) => $q->where(
                    'status',
                    $request->string('status')->toString()
                )
            )
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.programs.index', compact('programs'));
    }


    /**
     * Show create form.
     */
    public function create(): View
    {
        $media = Media::query()
            ->latest()
            ->get();

        return view('admin.programs.create', compact('media'));
    }


    /**
     * Store a new program.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        /*
        |--------------------------------------------------------------------------
        | Generate Slugs
        |--------------------------------------------------------------------------
        */

        if (blank($data['slug_en'])) {
            $data['slug_en'] = Str::slug($data['title_en']);
        }

        if (blank($data['slug_bn'])) {
            $data['slug_bn'] = Str::slug($data['title_bn']);

            /*
             * If Bangla text cannot produce a useful slug,
             * fall back to the English slug.
             */
            if (blank($data['slug_bn'])) {
                $data['slug_bn'] = $data['slug_en'];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Upload New Featured Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {
            $media = $this->uploadFeaturedImage(
                $request->file('featured_image'),
                $request
            );

            $data['featured_image_id'] = $media->id;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Program
        |--------------------------------------------------------------------------
        */

        Program::create($data);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(Program $program): View
    {
        $media = Media::query()
            ->latest()
            ->get();

        $program->load('featuredImage');

        return view(
            'admin.programs.edit',
            compact('program', 'media')
        );
    }


    /**
     * Update existing program.
     */
    public function update(
        Request $request,
        Program $program
    ): RedirectResponse {

        $data = $this->validated($request, $program);


        /*
        |--------------------------------------------------------------------------
        | Generate Slugs
        |--------------------------------------------------------------------------
        */

        if (blank($data['slug_en'])) {
            $data['slug_en'] = Str::slug($data['title_en']);
        }

        if (blank($data['slug_bn'])) {
            $data['slug_bn'] = Str::slug($data['title_bn']);

            if (blank($data['slug_bn'])) {
                $data['slug_bn'] = $data['slug_en'];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Remember Existing Image
        |--------------------------------------------------------------------------
        */

        $oldMedia = $program->featuredImage;


        /*
        |--------------------------------------------------------------------------
        | Upload Replacement Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('featured_image')) {

            $media = $this->uploadFeaturedImage(
                $request->file('featured_image'),
                $request
            );

            $data['featured_image_id'] = $media->id;

        } elseif ($request->boolean('remove_featured_image')) {

            /*
             * Remove featured image association.
             */
            $data['featured_image_id'] = null;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Program
        |--------------------------------------------------------------------------
        */

        $program->update($data);


        /*
        |--------------------------------------------------------------------------
        | Delete Old Featured Image
        |--------------------------------------------------------------------------
        |
        | Only delete the old media when:
        | - a new image replaced it, OR
        | - the featured image was removed.
        |
        */

        if (
            $oldMedia &&
            (
                $request->hasFile('featured_image') ||
                $request->boolean('remove_featured_image')
            )
        ) {
            $this->deleteMedia($oldMedia);
        }


        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }


    /**
     * Delete program.
     */
    public function destroy(Program $program): RedirectResponse
    {
        $program->load('featuredImage');

        $media = $program->featuredImage;

        $program->delete();

        /*
         * Delete the featured image associated with the program.
         */
        if ($media) {
            $this->deleteMedia($media);
        }

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }


    /**
     * Validate program data.
     */
    private function validated(
        Request $request,
        ?Program $program = null
    ): array {

        $enSlugRule = Rule::unique('programs', 'slug_en');
        $bnSlugRule = Rule::unique('programs', 'slug_bn');

        if ($program) {
            $enSlugRule->ignore($program->id);
            $bnSlugRule->ignore($program->id);
        }

        return $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'title_en' => [
                'required',
                'string',
                'max:255',
            ],

            'title_bn' => [
                'required',
                'string',
                'max:255',
            ],

            'slug_en' => [
                'nullable',
                'string',
                'max:255',
                $enSlugRule,
            ],

            'slug_bn' => [
                'nullable',
                'string',
                'max:255',
                $bnSlugRule,
            ],


            /*
            |--------------------------------------------------------------------------
            | Content
            |--------------------------------------------------------------------------
            */

            'short_description_en' => [
                'nullable',
                'string',
            ],

            'short_description_bn' => [
                'nullable',
                'string',
            ],

            'description_en' => [
                'nullable',
                'string',
            ],

            'description_bn' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Existing Media
            |--------------------------------------------------------------------------
            */

            'featured_image_id' => [
                'nullable',
                'uuid',
                'exists:media,id',
            ],


            /*
            |--------------------------------------------------------------------------
            | New Image Upload
            |--------------------------------------------------------------------------
            */

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'remove_featured_image' => [
                'nullable',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Publishing
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'published',
                    'archived',
                ]),
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],


            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'seo_title_en' => [
                'nullable',
                'string',
                'max:255',
            ],

            'seo_title_bn' => [
                'nullable',
                'string',
                'max:255',
            ],

            'seo_description_en' => [
                'nullable',
                'string',
            ],

            'seo_description_bn' => [
                'nullable',
                'string',
            ],
        ]);
    }


    /**
     * Upload featured image and create Media record.
     */
    private function uploadFeaturedImage(
        $file,
        Request $request
    ): Media {

        /*
        |--------------------------------------------------------------------------
        | Store Physical File
        |--------------------------------------------------------------------------
        */

        $path = $file->store(
            'programs',
            'public'
        );


        /*
        |--------------------------------------------------------------------------
        | Create Media Record
        |--------------------------------------------------------------------------
        */

        return Media::create([

            'uploaded_by' => auth()->id(),

            'file_name' => basename($path),

            'original_name' => $file->getClientOriginalName(),

            'file_path' => $path,

            'disk' => 'public',

            'mime_type' => $file->getMimeType(),

            'file_size' => $file->getSize(),

            /*
             * These can be edited later from the Media module.
             */
            'alt_text_en' => null,
            'alt_text_bn' => null,

            'title_en' => null,
            'title_bn' => null,

            'caption_en' => null,
            'caption_bn' => null,

            'metadata' => [
                'module' => 'programs',
                'uploaded_via' => 'program_featured_image',
            ],
        ]);
    }


    /**
     * Delete Media record and physical file.
     */
    private function deleteMedia(Media $media): void
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Physical File
        |--------------------------------------------------------------------------
        */

        if (
            $media->file_path &&
            Storage::disk($media->disk)->exists($media->file_path)
        ) {
            Storage::disk($media->disk)
                ->delete($media->file_path);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Media Database Record
        |--------------------------------------------------------------------------
        */

        $media->delete();
    }
}