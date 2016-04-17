@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $user->name }}
            </div>
            <div class="panel-body">
                {{ Form::open(array('route' => array('user.destroy', $user->id), 'method' => 'delete', 'onsubmit' => 'return confirm("Haluatko varmasti poistaa tilisi?")')) }}
                {{ Form::submit('Poista tili', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
