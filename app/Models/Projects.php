<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Projects extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */

    protected $table = 'projects';

    public $timestamps = false;

    public function getDefaultQuery(): Builder
    {
        return self::query()->select([
            'p.id', 'p.user_id', 'p.title', 'p.job_title', 'p.skills', 'p.description', 'p.time_months', 'p.company_name'
        ])->from("$this->table as p")
            ->leftJoin("resume_projects_links as pl", "pl.project_id", "=", "p.id");

    }
}
