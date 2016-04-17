@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3 class="text-center">
                {{ $project->name }}
            </h3>
            <dl class="dl-horizontal">
                <dt>
                    Kuvaus:
                </dt>
                <dd>
                    {{ $project->description }}
                </dd>
                <dt>
                    Aloitettu:
                </dt>
                <dd>
                    {{ $project->started_at }}
                </dd>
                <dt>
                    Aikaa käytetty:
                </dt>
                <dd class="time">
                    {{ $totaltime->total }}
                </dd>
                <dt>
                    Tila:
                </dt>
                <dd>
                    {{ $project->state->name }}
                </dd>
                
                <dt>
                    Käyttäjät:
                </dt>
                <dd>
@foreach ($project->users as $user)
                    {{ $user->name }} 
@endforeach
                </dd>
                <dt>
                    <a href={{ url(route('publicproject', array($project->id))) }}>julkinen linkki</a>
                </dt>
                <dt>
                    <a href={{ url(route('project.edit', array($project->id))) }}>muokkaa projektia</a>
                </dt>
                <dt>
                    <a href={{ url("/project/$project->id/invite") }}>kutsu käyttäjä</a>
                </dt>
@if (count($project->users) > 1)
                <dt>
                    <a href={{ url("/project/$project->id/leave") }}>poistu projektista</a>
                    </dt>
@endif
            </dl>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
@foreach ($errors->all() as $error)
            <span class="help-block">
                <strong>{{ $error }}</strong>
            </span>
@endforeach
            {{ Form::open(array('url' => route('timesheet.store') )) }}
            {{ Form::hidden('projectID', $project->id) }}
            {{ Form::hidden('timeTime', null, array('id' => 'timeTime')) }}
            <div id="timerdiv">
                {{ Form::text('timeComment', null, array('placeholder' => 'Mitä teet?', 'id' => 'timeComment')) }}
                {{ Form::select('timeCategory', $workCategories, null, array('id' => 'timeCategory')) }}
                <!--<i class="fa fa-angle-double-down"></i>-->
                {{ Form::text('klokka', '0:00', array('id' => 'klokka', 'style' => 'border:none;width:70px;text-align:center;')) }}
                {{ Form::button('<i class="fa fa-play" aria-hidden="true"></i>', array('id' => 'timerButton')) }}
            </div>
            
            <div id="accordion-1">
                <h3>Aseta aika ja päivämäärä käsin</h3>
                <div>
                    <input type="text" id="startTime" placeholder="Aloitusaika">
                    <input type="text" id="endTime" placeholder="Lopetusaika">
                    {{ Form::text('datepicker', null, array('id' => 'datepicker')) }}
                </div>
            </div>
            
            {{ Form::submit('Tallenna merkintä', array('id' => 'timeSubmit', 'class' => 'btn btn-success')) }}
            {{ Form::close() }}
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
@if (count($timesheets) > 0)
            <table style="margin:auto;">
            <tr>
                <th>Käyttäjä</th>
                <th>Kommentti</th>
                <th>Työtyyppi</th>
                <th>Päivämäärä</th>
                <th>Aika</th>
                <th></th>
            </tr>
@foreach ($timesheets as $timesheet)
            <tr>
                <td>
@if ($timesheet->user == null)
                null
@else
                {{ $timesheet->user }}
@endif
                </td>
                <td>{{ $timesheet->comment }}</td>
                <td>{{ $timesheet->category }}</td>
                <td>{{ $timesheet->d }}</td>
                <td class="time">{{ $timesheet->time }}</td>
                <td><a href={{ url(route('timesheet.edit', array($timesheet->id))) }}>muokkaa</a></td>
            </tr>
@endforeach
            <tr>
                <td colspan=4></td><td><label class="time">{{ $totaltime->total }}</label></td>
            </tr>
            </table>
@endif
        </div>
    </div>
</div>
<script src="{{ URL::asset('klokka.js') }}"></script>
@endsection
