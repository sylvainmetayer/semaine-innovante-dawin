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
    $('#actualTest').hide();
    $('#testRuffier').show();
    $('#afterTest_1').hide();

    startInterval = setInterval(function () {
        var timer = $('#timerBeforeStart');
        var timerValue = parseInt(timer.text());
        timer.text(timerValue - 1);
        if (timerValue === 0) {
            results.rest.time = new Date();
            var startTime = new Date().getTime();
            $('#countDown1').hide();
            $('#title-begin-test').hide();
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
    $('#afterTest').hide();
    $('#afterTest_1').show();

    var endTime = new Date();

    $("#submitEmail").click(function () {
        var email = $("#email").val();
        console.log(email);
        var form = {
            "email": email,
            "startTime": getStringDate(results.rest.time),
            "endTime": getStringDate(endTime),
            "userID": cfg.user_id
        };
        console.log(form);
        API.request("email", "addToCron").form(form).send(function (json) {
            console.log(json);
            a = json;
        })
    });
});