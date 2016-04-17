$("#accordion-1" ).accordion({
        'collapsible': 'true',
        'active': 'false'
});

$("#datepicker").datepicker({
    dateFormat: 'dd-mm-yy',
    maxDate: new Date()
});
$("#datepicker").datepicker('setDate', new Date());

$("#startTime, #endTime").timepicker({
    'scrollDefault': 'now',
    'timeFormat': 'H:i'});

$("#startTime, #endTime").change(function() {
    ticking = false;
    $("#timerButton").html('<i class="fa fa-play" aria-hidden="true"></i>');
    clearInterval(timervariable);
    var a = $("#startTime").val();
    var b = $("#endTime").val();
    var x = moment(a, 'HH:mm');
    var y = moment(b, 'HH:mm');
    var z = y.diff(x, 'seconds');
    if (!isNaN(z)) {
        timer = z;
        updateTimer();
    }
});

$("#timerButton").click(function(e) {
    toggleTimer();
});

$("#klokka").focus(function() {
    ticking = false;
    clearInterval(timervariable);
    $("#timerButton").html('<i class="fa fa-play" aria-hidden="true"></i>');
});

$("#klokka").change(function() {
    var tok = $("#klokka").val().split(':');
    var count = tok.length;
    if (count == 3)
        timer = parseInt(tok[0]*3600) + parseInt(tok[1]*60) + parseInt(tok[2]);
    else if (count == 2)
        timer = parseInt(tok[0]*60) + parseInt(tok[1]);        
    else if (count == 1)
        timer = parseInt(tok[0]);
    else
        timer = 0;
    if (isNaN(timer)) timer = 0;
    updateTimer();
});

$(".time").each(function() {
    $(this).html(secondsToHMS(parseInt($(this).html()), true));
});

var timer = 0;
var ticking = false;
var timervariable;

function secondsToHMS(seconds, fullformat) {
    var h = Math.floor(seconds / 3600);
    var m = Math.floor(seconds % 3600 / 60);
    var s = Math.floor(seconds % 3600 % 60);
    return (( (h > 0 || fullformat) ? h + ":" + (m < 10 ? "0" : "") : "") + m + ":" + (s < 10 ? "0" : "") + s);
}

function updateTimer() {
    if (ticking)
        timer++;
    if (timer > 360000)
        timer = 360000;
    var time = secondsToHMS(timer);
    document.title = "Tokkeli (" + time + ")";
    $("#klokka").val(time);
    $("#timeTime").val(timer);
}

function toggleTimer() {
    ticking = !ticking;
    if (ticking) {
        $("#timerButton").html('<i class="fa fa-pause" aria-hidden="true"></i>');
        timervariable = setInterval(updateTimer, 1000);
    } else {
        $("#timerButton").html('<i class="fa fa-play" aria-hidden="true"></i>');
        clearInterval(timervariable);
    }
}