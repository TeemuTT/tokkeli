<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tokkeli</title>
    
    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ URL::asset('mystyles.css') }}" rel="stylesheet">
</head>
<body id="app-layout">
    
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="text-align:center;">
            Ajankäytön seuranta toteutettu Tokkelilla. Tutustu palveluun <a href="{{ url('/') }}" target="_blank">tästä!</a>
        </div>
    </div>
    
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
            </dl>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
@if (count($timesheets) > 0)
            <table>
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
<script>
    function secondsToHMS(seconds, fullformat) {
        var h = Math.floor(seconds / 3600);
        var m = Math.floor(seconds % 3600 / 60);
        var s = Math.floor(seconds % 3600 % 60);
        return (( (h > 0 || fullformat) ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
    }
    $(".time").each(function() {
        $(this).html(secondsToHMS(parseInt($(this).html()), true));
    });
</script>
</body>
</html>