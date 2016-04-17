<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    
    public function state()
    {
        return $this->belongsTo('App\State', 'status_id');
    }
    
    public function timesheets()
    {
        return $this->hasMany('App\Timesheet')->orderBy('date', 'asc');
    }
}
