<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
