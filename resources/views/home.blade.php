@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                Projektit
            </div>
            <div class="panel-body">
                <div class="col-md-8">
                    @if (count($projects) == 0)
                        Sinulla ei ole yhtään projektia!<br>
                    @else
                    <ul>
                    @foreach ($projects as $project)
                        <li><a href={{ url(route('project.show', array($project->id))) }}>{{$project->name}}</a></li>
                    @endforeach
                    </ul>
                    @endif
                </div>
                <div class="col-md-4">
                    <a href={{ route('project.create') }} class="btn btn-success">Luo uusi projekti</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
