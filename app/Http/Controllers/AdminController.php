<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Lib;
use App\Models\Vacancies;
use View;



class AdminController extends Controller
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
        self::isAdmin();
        self::getData();
        return view('admin');
    }

    public function isAdmin () {
        $user_group = Auth::user()->user_group;
        if($user_group == 1) {
            return view('admin');
        } else {
            abort(404, 'Ошибка доступа');
        }
    }

    public static function getData () {
        $vacancies = Vacancies::all();
        View::share('vacancies', $vacancies);
    }

    public static function hideVacancy(Request $request) {
        $vacancy = Vacancies::find($request->id);
        $vacancy->is_hidden = !$vacancy->is_hidden;
        $vacancy->save();

        return view('templates.admin.vacancies_list', ['vacancies' => Vacancies::all()]);
    }


}