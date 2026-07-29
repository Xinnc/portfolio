<?php

namespace App\Actions\Project;

use App\DataTransferObjects\Project\StoreProjectData;
use App\DataTransferObjects\Project\StoreProjectMediaData;
use App\Models\Category;
use App\Models\Project;
use App\Models\Project_media;

class StoreProjectMediaAction
{
    public static function execute(Project $project, StoreProjectMediaData $data)
    {
        foreach ($data->media as $media) {
            $path = $media->store("project/{$project->id}", "public");
            $type = str_starts_with($media->getMimeType(), 'image/') ? 'image' : 'video';
            $project->media()->create([
                'project_id' => $project->id,
                'media_url' => $path,
                'type' => $type,
            ]);
        }

        return $project->load('media');
    }
}
