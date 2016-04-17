@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Kutsu käyttäjä</div>

                <div class="panel-body">
                    {{ Form::open(array('url' => "/project/".$projectID."/invite", 'role' => 'form')) }}
                    <div class="form-group">
                        <label for="invitedID">
                            Valitse kutsuttava käyttäjä
                        </label>
                        {{ Form::select('invitedID', $users, 0, array('class' => 'form-control')) }}
                    </div>
                    {{ Form::submit('Kutsu!', array('class' => 'btn btn-success')) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
