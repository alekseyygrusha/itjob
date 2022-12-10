<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Resume\ResumeLib;
use App\Models\Resume\Resume;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
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
        // return view('home');
    }


    public function deleteResume(Request $request) {
        $resume = Resume::where(['id' => $request->id, 'user_id' => Auth::id()])->get()->first();
        //ещё надо проверить все отклики с этим резюме и удалить их, если имеются
        dd($resume);
    }

}