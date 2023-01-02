<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resume\Resume;

class VacancyResponses extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
    */
    public $timestamps = false;
    protected $table = 'vacancies_links';

    public function user() {
        return $this->hasOne(User::class,  'id','user_id');
    }

    public function getResume() {
        return $this->hasOne(Resume::class,  'id','resume_id');
    }

}