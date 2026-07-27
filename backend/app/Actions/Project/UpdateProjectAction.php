<?php

namespace App\Actions\Project;

use App\DataTransferObjects\Project\UpdateProjectData;
use App\Models\Project;

class UpdateProjectAction
{
    public static function execute(Project $project, UpdateProjectData $data): Project
    {
        $updates = $data->getFilledFields();

        if(!empty($updates)) {
            $project->update($updates);
        }

        return $project;
    }
}
