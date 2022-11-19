<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacancies;
use App\Models\VacancyResponses;
use App\Models\Skills;
use App\Models\Cities;
use App\Models\Groups;
use App\Models\Lib;
use View;



class VacancyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        self::getData();
        return view('post');
    }

    public static function getData () {
        $skills = Skills::all();
        View::share('skills', $skills);
    }

    public function delete(Request $request) {
        $user_id = Auth::id();
        if (Lib::deleteVacancy($request->id, $user_id)) {
            return view('templates.cabinet.vacancies_list', ['user_vacancies' => Lib::getUserVacanciesList($user_id)]);
        }
    }

    public function postVacancy(Request $request) {
        if($request->vacancy_id) {
            $vacancy =  Vacancies::where('id', $request->vacancy_id)
                ->where('user_id', Auth::id())
                ->first();
            if(!$vacancy) {
                return false;
            }
            
            Lib::fillVacancySkillLinks($request->skills, $request->vacancy_id);
        } else {
            $vacancy = new Vacancies();
        }
        
        $vacancy->user_id = Auth::id();
        $vacancy->job_title = $request->job_title;
        $vacancy->job_group = $request->job_group;
        $vacancy->company_name = $request->company_name;
        $vacancy->city = $request->city;
        $vacancy->min_salary = $request->min_salary;
        $vacancy->max_salary = $request->max_salary;
        $vacancy->description = $request->description;
        $vacancy->save();

        return redirect()->route('cabinet')->with('success', 'Вакансия была опубликована');

    }
    public function getVanacyByGroup($group_id) {
        $group = Groups::where('id', $group_id)->get()->first();
       
        $vacancies = Vacancies::where('job_group', $group_id)
            ->with(['skills', 'vacancyResponses'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();

        return view('templates.vacancies.vacancies_list', ['vacancies' => $vacancies, 'success' => 'Фильтр по направлению ' . $group->group_name]);
    }
    public function getVanacyByCity($city_id) {
        $city = Cities::where('id', $city_id)->get()->first();
       
        $vacancies = Vacancies::where('city', $city_id)
            ->with(['skills', 'vacancyResponses'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();
        return view('templates.vacancies.vacancies_list', ['vacancies' => $vacancies, 'success' => 'Фильтр по городу ' . $city->name]);
    }

    public function getVanacy($id) {
        self::getData();
        $vacancy = self::getVacancyData($id);
        
        View::share('vacancy', $vacancy);
        return view('post');
    }

    public function getVacancyData($id) {
        $vacancy = Vacancies::find($id)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->with('skills')
            ->first();
        return $vacancy;
    }

    public function getVanacyResponses($id) {
        $vacancy_responses = VacancyResponses::where('vacancy_id', $id)
            ->with(['user'])
            ->get();    
        
        $vacancy = self::getVacancyData($id);    
      
        View::share('vacancy_responses', $vacancy_responses);    
        View::share('vacancy', $vacancy);

        return view('vacancy_responses');
    }

    public function vacancyResponse(Request $request) {

        $user_id=Auth::id();
        $vacancy_id = $request->id;

        $vacancy_link =  VacancyResponses::where('vacancy_id', $vacancy_id)
            ->where('user_id', $user_id)
            ->first();

        if($vacancy_link) {
            return false;
        }    

        $vacancy_link = new VacancyResponses;
        
        $vacancy_link->vacancy_id = $vacancy_id;
        $vacancy_link->user_id = $user_id;
        
        if($vacancy_link->save()) {
            return view('templates.vacancies.vacancies_list', 
            ['vacancies' => Vacancies::with('vacancyResponses')
                ->where('is_hidden', 0)
                ->where('is_blocked', 0)
                ->get(), 'success' => 'Отклик отправлен']);
        }
    }
}