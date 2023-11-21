<?php
namespace App\Services;

use App\Models\Project;

class ProjectsServices
{
    public static function getResumeProjects($resume_id)
    {
        $project = new Project();

        $query = $project->getDefaultQuery();
        $query->where('pl.resume_id', $resume_id);
        return $query->get();
    }

    public static function getProject($project_id)
    {
        $project = new Project();

        $query = $project->getDefaultQuery();
        $query->where('p.id', $project_id);
        return $query;
    }


}
