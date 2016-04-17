@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Luo uusi projekti</div>

                <div class="panel-body">
                    @if ($errors->has('newProjectName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('newProjectName') }}</strong>
                        </span>
                    @endif
                    {{ Form::open(array('url' => route('project.store'), 'role' => 'form')) }}
                    <div class="form-group">
                        <label for="newProjectName">
                            Nimi
                        </label>
                        {{ Form::text('newProjectName', null, array('placeholder' => 'Valitse hyvä nimi!', 'class' => 'form-control')) }}
                    </div>
                    <div class="form-group">
                        <label for="newProjectName">
                            Kuvaus
                        </label>
                        {{ Form::textarea('newProjectDescription', null, array('placeholder' => 'Anna projektille lyhyt kuvaus!', 'size' => '40x2', 'class' => 'form-control'))}}
                    </div>
                    {{ Form::submit('Luo!', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
