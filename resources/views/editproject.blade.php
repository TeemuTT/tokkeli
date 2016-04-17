@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">Muokkaa projektin tietoja</div>
            <div class="panel-body">
                @foreach ($errors->all() as $error)
                <span class="help-block">
                    <strong>{{ $error }}</strong>
                </span>
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        {{ Form::open(array('url' => route('project.update', $project->id), 'method' => 'put', 'role' => 'form')) }}
                        <div class="form-group">
                            <label for="newProjectName">
                                Nimi
                            </label>
                            {{ Form::text('newProjectName', $project->name, array('placeholder' => 'project name', 'id' => 'newProjectName', 'class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            <label for="newProjectDescription">
                                Kuvaus
                            </label>
                            {{ Form::textarea('newProjectDescription', $project->description, array('placeholder' => 'project description', 'size' => '40x2', 'id' => 'newProjectDescription', 'class' => 'form-control'))}}
                        </div>
                        <div class="form-group">
                            <label for="newProjectStatus">
                                Tila
                            </label>
                            {{ Form::select('newProjectStatus', $statusCategories, $project->status_id, array('id' => 'newProjectStatus', 'class' => 'form-control')) }}
                        </div>
                        {{ Form::submit('Päivitä!', array('class' => 'btn btn-success')) }}
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-warning">
                            Vaaravyöhyke!
                        </h3> 
                        {{ Form::open(array('route' => array('project.destroy', $project->id), 'method' => 'delete', 'onsubmit' => 'return confirm("Haluatko varmasti poistaa projektin?")')) }}
                        {{ Form::submit('Poista projekti', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
