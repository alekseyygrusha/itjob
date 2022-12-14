<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Vacancies extends Model
{
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
   
    public function vacancyResponses() {
        return $this->hasOne(VacancyResponses::class, 'vacancy_id')->where(['user_id' => Auth::id()]);
    }

    public function vacancyResponsesList() {
        return $this->hasMany(VacancyResponses::class, 'vacancy_id');
    }

    public function bindCity() {
        return $this->hasOne(Cities::class, 'id', 'city');
    }
}