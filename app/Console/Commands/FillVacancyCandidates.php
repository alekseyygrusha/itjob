<?php

namespace App\Console\Commands;

use App\Models\Resume\Resume;
use App\Models\SkillLinks;
use App\Models\Skills;
use App\Models\Vacancies;
use App\Models\VacancyCandidates;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;


/**
 * Сгенерировать карту сайта.
 */
class FillVacancyCandidates
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    static $skills = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    static $rating_coefficient = [
        'skill_coefficient' => 20,
        'months_coefficient' => 5,
        'salary_coefficient' => 2,
    ];

    /**
     * Execute the console command.
     *
     * @throws \Throwable
     * @return void
     */

    public function __construct()
    {
        self::$skills = Skills::where(['is_accept' => 1])->get();
    }

    public function handle()
    {

    }

    public static function start():void
    {
        $active_vacancies = Vacancies::where(['is_blocked' => 0, 'is_hidden' => 0])->get();

        foreach ($active_vacancies as $vacancy) {
            self::fillVacancyCandidates($vacancy);
        }
    }

    private static function fillVacancyCandidates($vacancy)
    {
        $candidates_resumes = Resume::where(['job_group' => $vacancy->job_group, 'active' => 1])->with(['projects'])->get();

        //Сюда поочерёдно записываем подсчёт опыта в проектах по каждой требуемой технологии
        $skills_time_experience = $vacancy->skills->keyBy('code')->map(function () {
            return [
                'time_months' => 0,
                'projects' => 0
            ];
        })->toArray();

        foreach($candidates_resumes as $candidate) {
            //записываем данные, которые у нас будут учитываться в системе рейтинга
            $candidate->rating_data = self::fillRatingData($candidate, $skills_time_experience, $vacancy);

            //производим подсчёт данных в очки рейтинга
            $candidate->rating_value = self::calculateRatingData($candidate->rating_data, $vacancy);
        }


        //Имея нужных кандидатов запишем их в таблицу кандидатов. При этом, если кандидат уже есть там, то просто обновим его данные (может он дополнил своё резюме)
        self::writeCandidatesInTable($candidates_resumes, $vacancy);


    }

    private static function writeCandidatesInTable($candidates_resumes, $vacancy)
    {
        foreach ($candidates_resumes as $candidate) {
            VacancyCandidates::updateOrCreate([
                'vacancy_id' => $vacancy->id,
                'resume_id' => $candidate->id
            ], [
                'salary_rating' => $candidate['rating_value']['salary_rating'],
                'skills_rating' => $candidate['rating_value']['skills_rating'],
                'projects_time_experience' => $candidate['rating_value']['projects_time_experience'],
                'rating' => $candidate['rating_value']['rating']
            ]);
        }
    }

    private static function calculateRatingData($rating_data, $vacancy)
    {
        $vacancy_months = intval($vacancy->experience->months);
        $rating = 0;
        $skills_rating = 0;

        foreach ($rating_data['skills'] as $skill_item) {
           //смотрим насколько хорошо кандидат подходит по каждому техническому навыку в своих проектах, используя требуемый опыт к вакансии как эталонный с разбросом 55% в обе стороны
           $skill_expected = self::isSkillExperienceCompliance($skill_item['time_months'], $vacancy_months, 55);
           $skills_rating = $skills_rating + $skill_expected;
        }

        $rating_statistic = [
            'skills_rating' => $skills_rating * self::$rating_coefficient['skill_coefficient'],
            'salary_rating' => $rating_data['salary_expected'] * self::$rating_coefficient['salary_coefficient'],
            'projects_time_experience' => $rating_data['projects_time_experience'] * self::$rating_coefficient['months_coefficient']
        ];

        foreach ($rating_statistic as $rating_item) {
            $rating = $rating + $rating_item;
        }
        $rating_statistic['rating'] = $rating;

        return $rating_statistic;
    }

    private static function fillRatingData($candidate, $skills_time_experience, $vacancy): array
    {
        $months_counter = 0;
        $time_experience = 0;
        $salary_rating = 0;

        if(!empty($candidate->min_salary) && (!empty($vacancy->max_salary) || !empty($vacancy->min_salary))) {
            $salary_rating = self::calculateSalaryRating($candidate->min_salary, $vacancy);
        }

        foreach ($candidate->projects as $project) {
            $project_skills = json_decode($project->skills);
            $time_experience = $time_experience + $project->time_months;
            foreach($project_skills as $skill_item) {
                $months_counter =  $months_counter + $project->time_months;
                $skills_time_experience[$skill_item->code]['time_months'] = $skills_time_experience[$skill_item->code]['time_months'] + $project->time_months;
                $skills_time_experience[$skill_item->code]['projects'] = $skills_time_experience[$skill_item->code]['projects'] + 1;
            }
        }

        return [
            'skills' => $skills_time_experience,
            'months_counter' => $months_counter,
            'projects_time_experience' => $time_experience,
            'salary_expected' => $salary_rating
        ];
    }



    private static function calculateSalaryRating($min_salary_resume, $vacancy): int
    {

        $salary_expected = 0;

        $vacancy_min_salary = intval(str_replace(' ','', $vacancy->min_salary));
        $vacancy_max_salary = intval(str_replace(' ','', $vacancy->max_salary));

        // тут либо берём среднее значение зп к вакансии, либо любое из указанных
        if($vacancy_min_salary) {
            $salary_expected = $vacancy_min_salary;
        }

        if($vacancy_max_salary) {
            $salary_expected = $vacancy_max_salary;
        }
        if($vacancy_max_salary && $vacancy_min_salary) {
            $salary_expected = ($vacancy_max_salary - $vacancy_min_salary) / 2 + $vacancy_min_salary;
        }

        $min_salary_resume = intval(str_replace(' ','', $min_salary_resume));
        $salary_vacancy = $salary_expected;

        $percentage_difference = ($salary_vacancy - $min_salary_resume) / ($salary_vacancy / 100); //разница в процентах от указанной в вакансии и у кандидата

        //вернём процентную разницу от эталонной в вакансии и указанной у кандидата
        return intval(100 - abs($percentage_difference));
    }

    private static function isSkillExperienceCompliance($time_months, $vacancy_months, $percentage_difference = 15)
    {
        $min_line = $vacancy_months - ($vacancy_months / 100 * $percentage_difference);
        $max_line = $vacancy_months + ($vacancy_months / 100 * $percentage_difference);

        return intval($min_line < $time_months && $time_months < $max_line);
    }

}
