<?php

namespace App\Http\Controllers;
use App\Console\Commands\FillVacancyCandidates;
use App\Models\VacancyCandidates;
use App\Services\VacancyServices;
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
        $data = self::getData();
        return view('post', $data);
    }

    public static function getData () {

        return [
            'skills' => response()->json(Skills::all()),
            'cities' => response()->json(Cities::all()),
            'groups' => response()->json(Groups::all()),
            'experiences' => response()->json(Experience::all()),
        ];
    }

    public function delete(Request $request) {
        $user_id = Auth::id();
        dd("delete");
        //сделать архивацию а не удаление
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

    public function getVacancyByGroup($group_id) {
        $group = Groups::where('id', $group_id)->get()->first();

        $vacancies = Vacancies::where('job_group', $group_id)
            ->with(['skills', 'vacancyResponses'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();

        return view('templates.vacancies.vacancies_list', ['vacancies' => $vacancies, 'success' => 'Фильтр по направлению ' . $group->group_name]);
    }
    public function getVacancyByCity($city_id) {
        $city = Cities::where('id', $city_id)->get()->first();

        $vacancies = Vacancies::where('city', $city_id)
            ->with(['skills', 'vacancyResponses'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();
        return view('templates.vacancies.vacancies_list', ['vacancies' => $vacancies, 'success' => 'Фильтр по городу ' . $city->name]);
    }

    public function getVacancy($id) {

        $data = self::getData();
        $vacancy = self::getVacancyData($id);
        $data['vacancy'] = $vacancy;

        return view('post', $data);
    }

    public function viewVacancy($id) {

        $data = self::getData();
        $vacancy = self::getVacancyData($id);

        $data['vacancy'] = $vacancy;
        View::share($data, $data);

        return view('vacancy.vacancy-card-view');
    }

    public function showVacancy($id) {

        self::getData();

        $vacancy = Vacancies::find($id)
            ->where('id', $id)
            ->with(['skills', 'experience', 'bindCity', 'vacancyResponses', 'status'])
            ->first();

        if($vacancy && $vacancy->status_code !== 'published') {
            return view('vacancy.vacancy404', ['status' => $vacancy->status_code]);
        }

        $resume_list = Resume::where(['user_id' => Auth::id()])->with(['city'])->get()->all();

        $data = [
            'vacancy' =>  $vacancy,
            'resume_list' => response()->json($resume_list)
        ];

        View::share($data);


        return view('vacancy.vacancy-card');
    }

    public function getVacancyData($id) {
        return Vacancies::find($id)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['skills', 'experience', 'bindCity', 'vacancyResponses'])
            ->first();
    }

    public function getVacancyResponses($id) {
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

    public function getVacancyCandidates(Request $request): JsonResponse {
        $candidates = VacancyServices::getVacancyCandidates($request->vacancy_id, 10, $request->filter);
        return response()->json($candidates);
    }

    public function inviteVacancyCandidate(Request $request) {
        $candidate = VacancyCandidates::where(['id' => $request->candidate_id])->get()->first();
        $candidate->is_accept = 1;

        $candidate->save();

        return true;
    }

    public function declineVacancyCandidate(Request $request) {
        $candidate = VacancyCandidates::where(['id' => $request->candidate_id])->get()->first();

        $candidate->is_rejected = 1;
        $candidate->save();

        return true;
    }

    public function acceptVacancy(Request $request) {
        $vacancy = Vacancies::where(['id' => $request->vacancy_id])->get()->first();

        $vacancy->status_code = 'rejected';
        $vacancy->save();

        return true;
    }

    public function setVacancyStatus(Request $request) {
        $vacancy = Vacancies::where(['id' => $request->vacancy_id])->get()->first();

        $vacancy->status_code = $request->status_code;
        $vacancy->save();

        return true;
    }

    public function getVacancyList(Request $request): JsonResponse {
        $vacancies = Vacancies::where(['status_code' => $request->status_code])->with(['status'])->get();

        return response()->json($vacancies);
    }

    public function getVacancyCard(Request $request): JsonResponse {
        $vacancy = Vacancies::where(['id' => $request->vacancy_id])->with(['bindCity', 'experience', 'skills'])->get()->first();

        return response()->json($vacancy);
    }

}
