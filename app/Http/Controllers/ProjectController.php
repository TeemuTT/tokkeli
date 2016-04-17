<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App;
use DB;
use Redirect;
use Carbon\Carbon;
use App\Project as Project;
use App\Timesheet as Timesheet;
use App\Category as Category;
use App\State as State;
use App\Http\Requests;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Näyttää kaikki käyttäjän projektit.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Auth::user()->projects;
        $data = array('projects' => $projects);
        return view('home', $data);
    }

    /**
     * Näytä lomake projektin luomiseen.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createproject');
    }

    /**
     * Tallenna uusi projekti.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'newProjectName' => 'required|unique:projects,name|max:50',
        ]);
        $user = Auth::user();
        $project = new Project;
        $project->name = $request->input('newProjectName');
        $project->description = $request->input('newProjectDescription');
        $project->started_at = Carbon::now()->format('d-m-Y');
        $project->status_id = 1;
        $project->save();
        $user->projects()->attach($project->id);
        
        return Redirect::to('/project');
    }

    /**
     * Näytä projekti.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $workCategories = Category::lists('name', 'id');
        $timesheets = DB::select(DB::raw("
            select ts.id, users.name as user, comment, categorys.name as category, strftime('%d-%m-%Y', date) as d, time
            from timesheets as ts
            left join users on ts.user_id = users.id
            left join categorys on ts.category_id = categorys.id
            where project_id = {$id}
            order by date desc"
        ));
        $totaltime = DB::select(DB::raw("select SUM(time) as total from timesheets where project_id = {$id};"));
        $totaltime = $totaltime[0];
        $data = array(
            'project' => $project,
            'workCategories' => $workCategories,
            'timesheets' => $timesheets,
            'totaltime' => $totaltime
        );
        return view('projectview', $data);
    }

    /**
     * Näytä lomake projektin muokkaamiseen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $statusCategories = State::lists('name', 'id');
        $data = array(
            'project' => $project,
            'statusCategories' => $statusCategories
        );
        return view('editproject', $data);
    }

    /**
     * Päivitä projektin tiedot.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'newProjectName' => 'required|unique:projects,name,'.$id.'|max:50',
        ]);
        $project = Project::findOrFail($id);
        $newName = $request->input('newProjectName');
        $newDesc = $request->input('newProjectDescription');
        $newStatus = $request->input('newProjectStatus');
        $project->name = $newName;
        $project->description = $newDesc;
        $project->status_id = $newStatus;
        $project->save();
        return Redirect::route('project.show', array($id));
    }

    /**
     * Poista projekti.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        foreach ($project->users as $user) {
            $user->projects()->detach($project->id);
        }
        // foreach ($project->timesheets as $timesheet) {
        //     $timesheet->delete();
        // }
        $project->delete();
        return Redirect::to('/project');
    }
    
    /**
    * Näytä lomake käyttäjän kutsumiseen.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function showInvite($id)
    {
        $data = array(
            // Keksi parempi kysely? Seulo pois jo osallistuvat.
            'users' => App\User::where('name', '!=', Auth::user()->name)->lists('name', 'id'),
            'projectID' => $id
        );
        return view('inviteview', $data);
    }
    
    /**
    * Lisää käyttäjä projektiin.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function invite(Request $request, $projectID)
    {
        $project = Project::findOrFail($projectID);
        $invitedUser = App\User::findOrFail($request->input('invitedID'));
        if ($invitedUser->projects()->find($projectID)) {
            $message = "Käyttäjä on jo projektissa!";
        }
        else {
            $invitedUser->projects()->attach($projectID);
            $message = "Käyttäjä " . $invitedUser->name . " kutsuttu projektiin " . $project->name . " onnistuneesti!";
        }
        
        $data = array(
            'message' => $message,
            'href' => "/project/{$projectID}/",
            'hrefMessage' => 'Takaisin projektiin'
        );
        return view('messageview', $data);
    }
    
    /**
    * Poistu projektista.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function leave($id)
    {
        $user = Auth::user();
        $user->projects()->detach($id);
        
        $data = array(
            'message' => 'Poistuit projektista "' . Project::find($id)->name . '"',
            'href' => "/project",
            'hrefMessage' => 'Takaisin projekteihin'
        );
        return view('messageview', $data);
    }
}
