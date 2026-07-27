<?php

namespace App\Actions\Project;

use App\Models\Category;
use App\Models\Project;

class IndexProjectAction
{
    public static function execute(Category $category)
    {
        $query = Project::where('category_id', $category->id)->with('media');
        if($type = request()->query('type'))
        {
            $query->whereHas('media', function ($query) use ($type) {
                $query->where('type', $type);
            });
        }
        if($date = request()->query('date'))
        {
            $query->orderBy('project_date', $date);
        }

        $projects = $query->paginate(3);

        return $projects;
    }
}
