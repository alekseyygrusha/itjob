<?php
namespace App\Services;

use App\Models\Projects;

class ProjectsServices
{
    public static function getResumeProjects($resume_id)
    {
        $project = new Projects();

        $query = $project->getDefaultQuery();
        $query->where('pl.resume_id', $resume_id);
        return $query->get();
    }
}
