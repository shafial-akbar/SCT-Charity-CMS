<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Program;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $projects = Project::query()->with(['program','featuredImage'])
            ->when($request->filled('search'), function($q) use ($request) {
                $s=$request->string('search')->toString();
                $q->where(fn($q)=>$q->where('title_en','like',"%$s%")
                    ->orWhere('title_bn','like',"%$s%")
                    ->orWhere('slug_en','like',"%$s%")
                    ->orWhere('slug_bn','like',"%$s%")
                    ->orWhere('location_en','like',"%$s%")
                    ->orWhere('location_bn','like',"%$s%"));
            })
            ->when($request->filled('status'), fn($q)=>$q->where('status',$request->string('status')->toString()))
            ->when($request->filled('program_id'), fn($q)=>$q->where('program_id',$request->string('program_id')->toString()))
            ->orderBy('start_date')->latest('created_at')->paginate(15)->withQueryString();

        $programs=Program::query()->orderBy('title_en')->get(['id','title_en','title_bn']);
        return view('admin.projects.index',compact('projects','programs'));
    }

    public function create(): View
    {
        $programs=Program::query()->orderBy('title_en')->get(['id','title_en','title_bn']);
        $media=Media::query()->latest()->get();
        return view('admin.projects.create',compact('programs','media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data=$this->validated($request);
        $data['slug_en']=$data['slug_en'] ?: Str::slug($data['title_en']);
        $data['slug_bn']=$data['slug_bn'] ?: Str::slug($data['title_bn']);
        if(blank($data['slug_bn'])) $data['slug_bn']=$data['slug_en'];

        if($request->hasFile('featured_image'))
            $data['featured_image_id']=$this->uploadFeaturedImage($request->file('featured_image'))->id;

        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success','Project created successfully.');
    }

    public function edit(Project $project): View
    {
        $project->load(['program','featuredImage']);
        $programs=Program::query()->orderBy('title_en')->get(['id','title_en','title_bn']);
        $media=Media::query()->latest()->get();
        return view('admin.projects.edit',compact('project','programs','media'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data=$this->validated($request,$project);
        $data['slug_en']=$data['slug_en'] ?: Str::slug($data['title_en']);
        $data['slug_bn']=$data['slug_bn'] ?: Str::slug($data['title_bn']);
        if(blank($data['slug_bn'])) $data['slug_bn']=$data['slug_en'];

        $oldMedia=$project->featuredImage;
        if($request->hasFile('featured_image'))
            $data['featured_image_id']=$this->uploadFeaturedImage($request->file('featured_image'))->id;
        elseif($request->boolean('remove_featured_image'))
            $data['featured_image_id']=null;

        $project->update($data);

        if($oldMedia && ($request->hasFile('featured_image') || $request->boolean('remove_featured_image')))
            $this->deleteMedia($oldMedia);

        return redirect()->route('admin.projects.index')->with('success','Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->load('featuredImage');
        $media=$project->featuredImage;
        $project->delete();
        if($media) $this->deleteMedia($media);
        return redirect()->route('admin.projects.index')->with('success','Project deleted successfully.');
    }

    private function validated(Request $request, ?Project $project=null): array
    {
        $en=Rule::unique('projects','slug_en');
        $bn=Rule::unique('projects','slug_bn');
        if($project){$en->ignore($project->id);$bn->ignore($project->id);}

        return $request->validate([
            'program_id'=>['nullable','uuid','exists:programs,id'],
            'title_en'=>['required','string','max:255'],'title_bn'=>['required','string','max:255'],
            'slug_en'=>['nullable','string','max:255',$en],'slug_bn'=>['nullable','string','max:255',$bn],
            'short_description_en'=>['nullable','string'],'short_description_bn'=>['nullable','string'],
            'description_en'=>['nullable','string'],'description_bn'=>['nullable','string'],
            'featured_image_id'=>['nullable','uuid','exists:media,id'],
            'featured_image'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'remove_featured_image'=>['nullable','boolean'],
            'location_en'=>['nullable','string','max:255'],'location_bn'=>['nullable','string','max:255'],
            'start_date'=>['nullable','date'],'end_date'=>['nullable','date','after_or_equal:start_date'],
            'status'=>['required',Rule::in(['draft','planned','active','completed','archived'])],
            'seo_title_en'=>['nullable','string','max:255'],'seo_title_bn'=>['nullable','string','max:255'],
            'seo_description_en'=>['nullable','string'],'seo_description_bn'=>['nullable','string'],
            'published_at'=>['nullable','date'],
        ]);
    }

    private function uploadFeaturedImage($file): Media
    {
        $path=$file->store('projects','public');
        return Media::create([
            'uploaded_by'=>auth()->id(),'file_name'=>basename($path),
            'original_name'=>$file->getClientOriginalName(),'file_path'=>$path,'disk'=>'public',
            'mime_type'=>$file->getMimeType(),'file_size'=>$file->getSize(),
            'alt_text_en'=>null,'alt_text_bn'=>null,'title_en'=>null,'title_bn'=>null,
            'caption_en'=>null,'caption_bn'=>null,
            'metadata'=>['module'=>'projects','uploaded_via'=>'project_featured_image'],
        ]);
    }

    private function deleteMedia(Media $media): void
    {
        if($media->file_path && Storage::disk($media->disk)->exists($media->file_path))
            Storage::disk($media->disk)->delete($media->file_path);
        $media->delete();
    }
}
