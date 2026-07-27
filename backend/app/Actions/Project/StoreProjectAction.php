<?php

namespace App\Actions\Project;

use App\DataTransferObjects\Project\StoreProjectData;
use App\Models\Category;
use App\Models\Project;

class StoreProjectAction
{
    public static function execute(Category $category, StoreProjectData $date)
    {
        $project = Project::create([
            'category_id' => $category->id,
            'title' => $date->title,
            'description' => $date->description,
            'project_date' => $date->project_date,
        ]);

        return $project;
    }
}
