<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use DB;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;

class ApiController extends Controller
{
    public function show($id)
    {
        $project = App\Project::findOrFail($id);
        $timesheets = DB::select(DB::raw("
            select ts.id, users.name as user, comment, categorys.name as category, strftime('%d-%m-%Y', date) as d, time
            from timesheets as ts
            join users on ts.user_id = users.id
            join categorys on ts.category_id = categorys.id
            where project_id = {$id}
            order by date desc"
        ));
        $totaltime = DB::select(DB::raw("select SUM(time) as total from timesheets where project_id = {$id};"));
        $totaltime = $totaltime[0];
        $data = array(
            'project' => $project,
            'timesheets' => $timesheets,
            'totaltime' => $totaltime
        );
        
        return view('chartview', $data);
    }
}
