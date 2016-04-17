<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use App;
use Redirect;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'user' => Auth::user()
        );
        return view('userview', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = App\User::find(Auth::user()->id);
        Auth::logout();
        foreach ($user->projects as $project) {
            $user->projects()->detach($project->id);
            if (count($project->users) == 0) {
                // foreach ($project->timesheets as $timesheet) {
                //     $timesheet->delete();
                // }
                $project->delete();
            }
        }
        $user->delete();
        return Redirect::to('/');
    }
}
