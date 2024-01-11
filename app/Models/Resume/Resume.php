<?php
namespace App\Models\Resume;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use App\Models\Skills;
use App\Models\Cities;
use App\Models\Groups;

class Resume extends Model
{
    public $timestamps = false;
    protected $table = 'resume';
    public function link()
    {
        $this->belongsToMany(Project::class);
    }
    public function skills() {
        return $this->belongsToMany(Skills::class, 'resume_skills', 'resume_id', 'skill_id');
    }

    public function projects() {
        return $this->belongsToMany(Project::class, 'project_resume', 'resume_id', 'project_id');
    }

    public function experience() {
        return $this->hasOne(Experience::class, 'id', 'experience_time');
    }

    public function city() {
        return $this->hasOne(Cities::class, 'id', 'city_id');
    }

    public function group() {
        return $this->hasOne(Groups::class, 'id', 'job_group');
    }
}
