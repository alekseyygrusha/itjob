<?php
namespace App\Models;
use App\Models\Resume\Resume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */

    protected $table = 'projects';

    public $timestamps = false;
    public function link()
    {
        return $this->belongsToMany(Resume::class);
    }
    public function getDefaultQuery(): Builder
    {
        return self::query()->select([
            'p.id', 'p.user_id', 'p.title', 'p.job_title', 'p.skills', 'p.description', 'p.time_months', 'p.company_name'
        ])->from("$this->table as p")
            ->leftJoin("project_resume as pl", "pl.project_id", "=", "p.id");

    }
}
