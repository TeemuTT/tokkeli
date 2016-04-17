@extends('layouts.app')
@section('content')
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                Muokkaa aikamerkintää
            </div>
            <div class="panel-body">
@foreach ($errors->all() as $error)
                <span class="help-block">
                    <strong>{{ $error }}</strong>
                </span>
@endforeach
                <div class="row">
                    <div class="col-md-12">
                        {{ Form::open(array('url' => route('timesheet.update', $timesheet->id), 'method' => 'put', 'role' => 'form')) }}
                        {{ Form::hidden('newTime', $timesheet->time, array('id' => 'newTime')) }}
                        <div class="form-group">
                            <label for="newComment">
                                Kommentti
                            </label>
                            {{ Form::text('newComment', $timesheet->comment, array('placeholder' => 'comment', 'id' => 'newComment', 'class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            <label for="newCategory">
                                Työtyyppi
                            </label>
                            {{ Form::select('newCategory', $workCategories, $timesheet->category_id, array('id' => 'newCategory', 'class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            <label for="klokka">
                                Aika
                            </label>
                            {{ Form::text('klokka', $timesheet->time, array('id' => 'klokka', 'class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            <label for="datepicker">
                                Päivämäärä
                            </label>
                            {{ Form::text('datepicker', null, array('id' => 'datepicker', 'class' => 'form-control')) }}
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
                        {{ Form::open(array('route' => array('timesheet.destroy', $timesheet->id), 'method' => 'delete', 'onsubmit' => 'return confirm("Haluatko varmasti poistaa merkinnän?")')) }}
                        {{ Form::submit('Poista', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function secondsToHMS(seconds, fullformat) {
        var h = Math.floor(seconds / 3600);
        var m = Math.floor(seconds % 3600 / 60);
        var s = Math.floor(seconds % 3600 % 60);
        return (( (h > 0 || fullformat) ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
    }
    
    $("#klokka").val(secondsToHMS( {{ $timesheet->time }} ));
    
    $("#datepicker").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $("#datepicker").datepicker('setDate', '<?php $date = date_create_from_format("Y-m-d H:i:s", $timesheet->date); echo $date->format("d-m-Y"); ?>');
    
    $("#klokka").change(function() {
        var timer = 0;
        var tok = $("#klokka").val().split(':');
        var count = tok.length;
        if (count == 3)
            timer = parseInt(tok[0] * 3600) + parseInt(tok[1] * 60) + parseInt(tok[2]);
        else if (count == 2)
            timer = parseInt(tok[0] * 60) + parseInt(tok[1]);
        else if (count == 1)
            timer = parseInt(tok[0]);
        else
            timer = 0;
        if (isNaN(timer)) timer = 0;
        $("#newTime").val(timer);
    });
</script>
@endsection
