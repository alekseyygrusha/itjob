<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;

class Lib
{
    public static function getVacanciesList () {
        $vacancies = DB::table('vacancies as v')
            ->select('v.job_title', 'v.description', 'v.id', 'v.company_name', 'v.description', 'v.min_salary', 'v.max_salary', 'v.is_blocked', 'v.is_hidden', 'cl.name as city_name')
            ->join('city_list as cl','cl.id', '=', 'v.city', )
            ->where('v.is_hidden', '=', 0)
            ->get();
        foreach($vacancies as &$vacancy) {
            self::fillVacancySkills($vacancy);
        }
        
        return $vacancies;
    }

    public static function fillVacancySkills($vacancy) {
      
        $id = $vacancy->id;

        $skills =  DB::table('skill_links as sl')
            ->select('sl.id', 'sl.vacancy_id', 'sl.skills_id', 's.name')
            ->join('skills as s','s.id', '=', 'sl.skills_id', )
            ->where('sl.vacancy_id', $vacancy->id)
            ->get();
       
        $vacancy->skills = $skills;
    }

    public static function deleteVacancy($id, $user_id) {
        $vacancy = DB::table('vacancies')
            ->where('vacancies.user_id' , $user_id)
            ->where('vacancies.id' , $id);
            
        if(!$vacancy) {
            return false;
        }
        self::deleteVacancyLinks($id);
        self::deleteBindVacancySkills($id);
        $vacancy->delete();
        
        return true;
    }

    public static function deleteVacancyLinks($id) {
        $skill_links = DB::table('vacancies_links')
            ->where('vacancies_links.vacancy_id', $id)
            ->delete();
    }

    public static function deleteBindVacancySkills($id) {
        $skill_links = DB::table('skill_links')
            ->where('skill_links.vacancy_id', $id)
            ->delete();
    }

    public static function fillVacancySkillLinks($skills, $vacancy_id) {
        //Переписать на Laravel!
        self::deleteBindVacancySkills($vacancy_id);
        if($skills) {
            foreach ($skills as $skill) {
                DB::table('skill_links')->insert(
                    ['skills_id' => $skill, 'vacancy_id' => $vacancy_id],
                );
            }
        }
        
    }
    


    
}