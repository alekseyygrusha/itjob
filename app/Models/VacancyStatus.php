<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class VacancyStatus extends Model
{
    /**
     * Таблица БД, ассоциированная с моделью.
     *
     * @var string
     */
    public $timestamps = false;
    protected $table = 'vacancy_status';

}
