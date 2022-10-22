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
       
        $list_vacancies = Vacancies::with(['vacancyResponses', 'bindCity'])
            ->where('is_hidden', 0)
            ->where('is_blocked', 0)
            ->get();

        $groups_list = Groups::get()->all();
    
        // dd($list_vacancies);
        $data = [
            'city_list' => $city_list,
            'groups_list' => $groups_list,
            'vacancies' => $list_vacancies
        ];

        View::share($data);
    }
}