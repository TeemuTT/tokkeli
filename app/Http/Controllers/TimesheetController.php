<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Auth;
use Redirect;
use Carbon\Carbon;
use App;
use App\Project as Project;
use App\Timesheet as Timesheet;
use App\Http\Requests;

class TimesheetController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'timeComment' => 'required|max:50',
            'timeTime' => 'required|integer|min:1',
            'datepicker' => 'required|date:DD-MM-YY',
        ]);
        $user = Auth::user();
        $time = $request->input('timeTime');
        $date = $request->input('datepicker');
        $date = date_create_from_format('d-m-Y', $date);
        $comment = $request->input('timeComment');
        $projectID = $request->input('projectID');
        $category = $request->input('timeCategory');
        
        $timesheet = new Timesheet;
        $timesheet->time = $time;
        $timesheet->date = $date;
        $timesheet->comment = $comment;
        $timesheet->user_id = $user->id;
        $timesheet->category_id = $category;
        $timesheet->project_id = $projectID;
        $timesheet->save();
        return Redirect::route('project.show', array($projectID));
    }

    /**
     * Näytä lomake aikatapahtuman muokkaamiseen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $workCategories = App\Category::lists('name', 'id');
        $data = array(
            'timesheet' => $timesheet,
            'workCategories' => $workCategories
        );
        return view('edittimesheet', $data);
    }

    /**
     * Päivitä aikatapahtuma.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'newComment' => 'required|max:50',
            'newTime' => 'required|integer|min:1',
            'datepicker' => 'required|date:DD-MM-YY',
        ]);
        $newTime = $request->input('newTime');
        $newDate = $request->input('datepicker');
        $newDate = date_create_from_format('d-m-Y', $newDate);
        $newComment = $request->input('newComment');
        $newCategory = $request->input('newCategory');
        
        $timesheet = Timesheet::findOrFail($id);
        $timesheet->time = $newTime;
        $timesheet->date = $newDate;
        $timesheet->comment = $newComment;
        $timesheet->category_id = $newCategory;
        $timesheet->save();
        return Redirect::route('project.show', array($timesheet->project_id));
    }

    /**
     * Poista aikatapahtuma.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $projectID = $timesheet->project_id;
        $timesheet->delete();
        return Redirect::route('project.show', array($projectID));
    }
}
