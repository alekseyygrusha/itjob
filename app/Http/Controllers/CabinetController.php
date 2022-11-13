<?php
namespace App\Http\Controllers;

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
        $city_list = Cities::get()->all();
        $groups_list = Groups::get()->all();
        $skills = Skills::get()->all();

        return view('resume.resume-card', ['resume' => $resume, 
        'city_list' => $city_list, 
        'groups_list' => $groups_list,
        'skills' => $skills]);
    }

    public static function getData () {
        $user_vacancies = Lib::getUserVacanciesList(Auth::id());
        View::share('user_vacancies', $user_vacancies);
    }

}