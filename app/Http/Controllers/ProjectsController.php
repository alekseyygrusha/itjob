<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Resume\Resume;
use App\Services\ProjectsServices;
use Illuminate\Http\Request;
use Spatie\FlareClient\Flare;
use Spatie\Ignition\Config\IgnitionConfig;
use Spatie\Ignition\ErrorPage\ErrorPageViewModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class ProjectsController extends Controller
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
    public function getProject(Request $request): JsonResponse
    {
        $id = $request->id;
        $project = ProjectsServices::getProject($id);
        return response()->json($project->get()->first()->toArray());
    }

    public function saveProject(Request $request)
    {
        $project = new Project();

        if($request->id) {

            $project = $project->find($request->id);
        }

        $project->user_id = Auth::id();
        $project->title = $request->title;
        $project->job_title = $request->job_title;
        $project->description = $request->description;
        $project->time_months = $request->time_months;
        $project->company_name = $request->company_name;

        //переделать. Надо создать модель для связующей таблицы

        $project->save();


        if($request->resume_id) {
            $exist = $project->link()
                ->where('project_id', $request->id)
                ->where('resume_id', $request->resume_id)
                ->exists();
            if(!$exist) {
                $resume = new Resume();
                $resume = $resume->find($request->resume_id);

                $project->link()->save($resume);
            }
        }

        return true;
    }

    public function getProjectsList(Request $request): JsonResponse
    {
        $id = $request->id;
        $project = ProjectsServices::getResumeProjects($id);

        return response()->json($project->toArray());
    }

    public function deleteResumeProject(Request $request)
    {
        $id = $request->id;
        $project = ProjectsServices::getProject($id);

        if($project->delete()) {
            return true;
        }
        return false;
    }


}
