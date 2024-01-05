<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VacancyCandidates extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'vacancy_candidates';

    protected $guarded = [];

    public function getDefaultQuery(): Builder
    {
        return self::query()->select(['r.id as resume_id','c.id as candidate_id', 'r.active', 'r.user_id', 'r.job_title', 'r.city_id', 'r.experience_time', 'r.description', 'r.max_salary', 'r.min_salary', 'r.job_group', 'c.name as city_name', 'vc.is_accept', 'vc.is_rejected'])
            ->from("resume as r")
            ->leftJoin("$this->table as vc", "vc.resume_id", "=", "r.id")
            ->leftJoin('city_list as c', 'c.id', '=', 'r.city_id');

    }

    public function getCandidateSkillsQuery(): Builder
    {
        return self::query()->select(['*'])
            ->from("resume_skills as rs")
            ->leftJoin("skills as s", "s.id", "=", "rs.skill_id");

    }
}
