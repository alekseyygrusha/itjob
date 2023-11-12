<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use App\Models\Lib;
use App\Models\Vacancies;
use App\Models\Cities;
use App\Models\Groups;
use App\Models\Skills;
use App\Models\Resume\Resume;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use View;

class RootController extends Controller
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
        return view('root');
    }

    public static function getData () {
        $city_list = Cities::get()->all();
       
        $list_vacancies = Vacancies::with(['vacancyResponses', 'bindCity', 'skills' , 'experience'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();
        
        $resume_list = Resume::where(['user_id' => Auth::id()])->with(['city'])->get()->all();
       
        $groups_list = Groups::get()->all();
     
        // dd($list_vacancies);
        $data = [
            'cities' => response()->json(Cities::all()),
            'groups_list' => $groups_list,
            'vacancies' => $list_vacancies,
            'resume_list' => response()->json($resume_list),
            'skills' => response()->json(Skills::all()),
            'experiences' => response()->json(Experience::all()),
        ];
        
        View::share($data);
    }
}