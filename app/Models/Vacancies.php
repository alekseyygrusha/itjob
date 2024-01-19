<?php
namespace App\Models;
use App\Models\Resume\Resume;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Vacancies extends Model
{
    Use HasFactory;
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
    */
    public $timestamps = false;
    protected $table = 'vacancies';


    public function skills() {
        // return $this->hasMany(Skills::class, 'foreign_key', 'local_key');
        return $this->belongsToMany(Skills::class, 'skill_links', 'vacancy_id', 'skills_id');
    }

    public function candidates() {
        return $this->belongsToMany(Resume::class, 'vacancy_candidates', 'vacancy_id', 'resume_id');
    }

    public function vacancyResponses() {
        return $this->hasOne(VacancyResponses::class, 'vacancy_id')->where(['user_id' => Auth::id()]);
    }

    public function vacancyResponsesList() {
        return $this->hasMany(VacancyResponses::class, 'vacancy_id');
    }

    public function bindCity() {
        return $this->hasOne(Cities::class, 'id', 'city');
    }

    public function experience() {
        return $this->hasOne(Experience::class, 'id', 'expirience_id');
    }

    public function status() {
        return $this->hasOne(VacancyStatus::class, 'code', 'status_code');
    }
}
