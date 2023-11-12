<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Vacancies;
use App\Models\VacancyResponses;
use App\Models\Resume\Resume;
use App\Models\Skills;
use App\Models\Cities;
use App\Models\Groups;
use App\Models\Lib;
use App\Models\Experience;
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
       
        $data = [
            'skills' => response()->json(Skills::all()),
            'cities' => response()->json(Cities::all()),
            'groups' => response()->json(Groups::all()),
            'experiences' => response()->json(Experience::all()),
        ];
       
       
        View::share($data);
    }

    public function delete(Request $request) {
        $user_id = Auth::id();
        if (Lib::deleteVacancy($request->id, $user_id)) {
            return view('templates.cabinet.vacancies_list', ['user_vacancies' => Lib::getUserVacanciesList($user_id)]);
        }
    }

    public function postVacancy(Request $request) {
        
        if($request->id) {
            $vacancy =  Vacancies::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->first();
            if(!$vacancy) {
                return false;
            }
            
            Lib::fillVacancySkillLinks($request->vacancy_skills, $request->id);
        } else {
            $vacancy = new Vacancies();
        }
        
        $vacancy->user_id = Auth::id();
        $vacancy->job_title = $request->job_title;
        $vacancy->job_group = $request->group_id;
        $vacancy->company_name = $request->company_name;
        $vacancy->city = $request->city_id;
        $vacancy->min_salary = $request->salary_min;
        $vacancy->max_salary = $request->salary_max;
        $vacancy->expirience_id = $request->expirience_id;
        $vacancy->description = $request->description;
        $vacancy->save();

        return response()->json(['answer' => true]);

    }

    public function filterVacancies(Request $request) {
        dd($request);
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
        
        View::share('vacancy',  $vacancy);
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
            ->with(['getResume', 'getVacancy'])
            ->get();    
       
        $vacancy = self::getVacancyData($id);    
        // $this->checkResumeCompetencies($vacancy_responses, $vacancy);

        $data = [
            'vacancy_responses' => $vacancy_responses,
            'vacancy' => $vacancy
        ];

        View::share($data);    
        
        return view('vacancy_responses');
    }

    public function checkResumeCompetencies(&$vacancy_responses, $vacancy) {
        $competencies = ['experience_time', 'skills'];
        $points = 0;
        
        foreach($vacancy_responses as $response) {
            $response_resume = $response->getResume->toArray();
           
            foreach($response_resume as $key => $resume_item) {
                if(in_array($key, $competencies) && $resume_item ) {
                    $points++;
                }
                
                
            }
        }
    }

    public function vacancyResponse(Request $request) {
        $user_id=Auth::id();
        $vacancy_id = $request->vacancy_id;
        $resume_id = $request->resume_id;
        
        $vacancy_link = new VacancyResponses;
        $vacancy_link->vacancy_id = $vacancy_id;
        $vacancy_link->resume_id = $resume_id;
        $vacancy_link->user_id = $user_id;

        $resume_list = Resume::where(['user_id' => Auth::id()])->with(['city'])->get()->all();

        if(!$vacancy_link->save()) {
            return false;
        }
          
        return view('templates.vacancies.vacancies_list', 
            [
                'vacancies' => Vacancies::with('vacancyResponses')
                    ->where('is_hidden', 0)
                    ->where('is_blocked', 0)
                    ->get(), 'success' => 'Отклик отправлен',
                'resume_list' => response()->json($resume_list)
            ],
        );
        
    }

    public function cancelResponseVacancy(Request $request) {
        $user_id=Auth::id();
        $vacancy_id = $request->vacancy_id;
        $resume_id = $request->resume_id;

        $vacancy_link = VacancyResponses::where(['vacancy_id'=> $vacancy_id, 'resume_id' => $resume_id, 'user_id' => $user_id])
            ->first();
        if(!$vacancy_link) {
            return false;
        }

        $vacancy_link->userCancel = true;

        return true;
    }

    public function acceptResponseVacancy(Request $request) {
        $params = $request->all();
      
        $vacancy_response = VacancyResponses::where(['id'=> $params['response_id']])
            ->first();
        if(!$vacancy_response) {
            return false;
        }
        $vacancy_response->isChecked = true;
        $vacancy_response->isAccept = true;
        $vacancy_response->save();

        return true;
    }

    public function declineResponseVacancy(Request $request) {
        $params = $request->all();
      
        $vacancy_response = VacancyResponses::where(['id'=> $params['response_id']])
            ->first();
        
        if(!$vacancy_response) {
            return false;
        }
        $vacancy_response->isChecked = true;
        $vacancy_response->isAccept = false;
        $vacancy_response->save();

        return true;
    }
    
}