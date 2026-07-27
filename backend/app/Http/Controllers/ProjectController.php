<?php

namespace App\Http\Controllers;

use App\Actions\Project\IndexProjectAction;
use App\Actions\Project\StoreProjectAction;
use App\Actions\Project\StoreProjectMediaAction;
use App\Actions\Project\UpdateProjectAction;
use App\DataTransferObjects\Project\StoreProjectData;
use App\DataTransferObjects\Project\StoreProjectMediaData;
use App\DataTransferObjects\Project\UpdateProjectData;
use App\Models\Category;
use App\Models\Project;
use App\Models\Project_media;
use Illuminate\Support\Facades\Storage;
class ProjectController extends Controller
{
    public function index(Category $category)
    {
        $project = IndexProjectAction::execute($category);

        return response()->json([
            'project' => $project,
            'category' => $category->title
        ]);
    }

    public function store(Category $category, StoreProjectData $date)
    {
        $project = StoreProjectAction::execute($category, $date);

        return response()->json([
            'message' => 'Проект успешно добавлен!',
            'data' => $project,
        ]);
    }

    public function storeMedia(Project $project, StoreProjectMediaData $date)
    {
        StoreProjectMediaAction::execute($project, $date);

        return response()->json([
            'message' => 'Медиа успешно загружены!',
        ]);
    }

    public function getMedia(Project $project)
    {
        return response()->json([
            'message' => Project_media::where('project_id', $project->id)->get(),
        ]);
    }

    public function update(Project $project, UpdateProjectData $date)
    {
        UpdateProjectAction::execute($project, $date);

        return response()->json([
            'message' => 'Проект успешно обновлен!'
        ]);
    }

    public function destroy(Project $project)
    {
        $project->media->each(function($media) {
            Storage::disk('public')->delete($media->media_url);
        });

        $project->media()->delete();

        $project->delete();

        return response()->noContent(204);
    }

    public function destroyMedia(Project_media $media)
    {
        if($media->media_url) {
            Storage::disk('public')->delete($media->media_url);
        }
        $media->delete();
        return response()->noContent(204);
    }
}
