<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


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
        return $this->hasOne(User::class, 'id');
    }

}