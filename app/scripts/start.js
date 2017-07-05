var results = {
    "rest": {
        "time": "",
        "hr": "",
    },
    "after_effort": {
        "time": "",
        "hr": "",
    },
    "after_effort_and_rest": {
        "time": "",
        "hr": ""
    }
};
var $startButton = $('#startRuffier');
var startInterval;
var exerciseInterval;

function getStringDate(date) {
    return date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
}

$startButton.click(function () {
    $('#title-test').hide();
    $startButton.hide();
    $('#cardiacRythmAtStart').hide();
    results.rest.time = getStringDate(new Date());
    $('#actualTest').hide();
    $('#testRuffier').show();

    startInterval = setInterval(function () {
        var timer = $('#timerBeforeStart');
        var timerValue = parseInt(timer.text());
        timer.text(timerValue - 1);
        if (timerValue === 0) {
            var startTime = new Date().getTime();
            $('#countDown1').hide();
            $('#actualTest').show();
            exerciseInterval = setInterval(function () {
                var actualTime = new Date().getTime();
                $('#testTimer').text(Math.floor((actualTime - startTime) / 1000));
            }, 1000)
        }
    }, 1000);
});

$('#endExercise').click(function () {

    clearInterval(startInterval);
    clearInterval(exerciseInterval);
    $('#actualTest').hide();
    $('#afterTest').show();

    var cpt = 0;
    var getRequiredDateInterval = setInterval(function () {
        cpt = cpt + 1;
        if (cpt === 15) {
            results.after_effort.time = getStringDate(new Date());
        }
        else if (cpt === 75) {
            results.after_effort_and_rest.time = getStringDate(new Date());
        }
        else if (cpt >= 76) {
            alert("Veuillez synchronisez votre fitbit s'il ne se trouve pas enc synchro auto, et veuillez patienter jusqu'à 5min pour obtenir les résultats.");
            [results.rest, results.after_effort, results.after_effort_and_rest].forEach(function (e) {
                getHR_atDate(e.time, e);
                console.log(e);
            });
            clearInterval(getRequiredDateInterval);
        }
    }, 1000)
});