<?php
namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\VacancyCandidates;
use App\Services\ProjectsServices;
use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Lib;
use App\Models\Cities;
use App\Models\Groups;
use App\Models\Skills;
use App\Models\Resume\ResumeLib;
use App\Models\Vacancies;
use App\Models\Resume\Resume;
use App\Models\VacancyResponses;
use View;



class CabinetController extends Controller
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
        return view('cabinet');
    }

    public function getResume($id) {
        $resume = ResumeLib::getResumeData($id);

        $projects = ProjectsServices::getResumeProjects($id);

        $data = [
            'resume' => $resume,
            'projects' => $projects,
            'skills' => Skills::all(),
            'cities' => Cities::all(),
            'groups' => Groups::all(),
            'experiences' => Experience::all(),
        ];

        return view('resume.resume-card', $data);
    }

    public static function createResume()
    {
        $data = [
            'skills' => Skills::all(),
            'cities' => Cities::all(),
            'groups' => Groups::all(),
            'experiences' => Experience::all(),
        ];

        return view('resume.resume-card', $data);
    }

    public static function invites()
    {
        $user_resumes = Resume::where(['user_id' => Auth::id()])->get()->pluck('id');

        $vacancies_invites = VacancyCandidates::whereIn('resume_id', $user_resumes)
            ->where(['is_accept' => 1])->with(['resume', 'vacancy.bindCity'])->get()->all();

        return view('cabinet.invites', ['vacancies_invites' => $vacancies_invites]);
    }


    public static function postPage()
    {
        return view('cabinet.post_page');
    }

    public function publishResume(Request $request) {
        $resume_id = $request->resume_id;

        $resume = new Resume;
        if($resume_id) {
            $resume = Resume::where(['id' => $resume_id])->with(['skills'])->get()->first();
        }

        $resume->job_group = $request->job_group;
        $resume->user_id = Auth::id();
        $resume->job_title = $request->job_title;
        $resume->city_id = $request->city_id;
        $resume->experience_time = $request->experience_time;

        $resume->min_salary = $request->salary_min;
        $resume->max_salary = $request->salary_max;
        $resume->save();
        if($resume->id) {
            ResumeLib::fillResumeSkillLinks($request->skills, $resume->id);
        }

        self::getData();
        return view('cabinet', ['success' => 'Изменения сохранены']);

    }

    public static function getData () {
        $vacancies = Vacancies::with(['vacancyResponsesList', 'bindCity', 'skills', 'status'])->where(['user_id' => Auth::id()])->get();

        $user_resume = Resume::where(['user_id' => Auth::id()])->with(['city', 'skills'])->get();
        // dd($user_resume);
        $data = [
            'user_vacancies' => $vacancies,
            'user_resumes' => $user_resume
        ];

        View::share($data);
    }

    public function getResposes() {
        $vacancies_responses = VacancyResponses::with(['getVacancy', 'getResume'])->where(['user_id' => Auth::id()])->get();

        return view('responses', ['vacancies_responses' => $vacancies_responses]);
    }
}
