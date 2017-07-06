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

function getRuffier(a, b, c) {
    return (parseInt(a) + parseInt(b) + parseInt(c) - 200) / 10;
}

$('#endExercise').click(function () {

    clearInterval(startInterval);
    clearInterval(exerciseInterval);
    $('#actualTest').hide();
    $('#afterTest').hide();
    $('#afterTest_1').show();

    var endTime = new Date();

    API.request("result", "selectResult").form({
        "id_user_fitbit": cfg.user_id
    }).send(function (json) {
        json.forEach(function (e) {
            var li = $("<li>");
            var text = "Le " + e.date + ", premier HR : " + e.first_hr;
            text += ", 2ème HR :" + e.second_hr + " et 3ème HR : " + e.third_hr;
            text += ". Cela vous donne un résultat de Ruffier de " + getRuffier(e.first_hr, e.second_hr, e.third_hr);
            li.html(text);
            $("#previousTest").append(li);
        });
    });

    $("#submitEmail").click(function () {
        var email = $("#email").val();
        console.log(email);
        var form = {
            "email": email,
            "startTime": getStringDate(results.rest.time),
            "endTime": getStringDate(endTime),
            "userID": cfg.user_id,
            "token": fitbitAccessToken
        };
        console.log(form);
        API.request("email", "addToCron").form(form).send(function (json) {
            console.log(json);
            alert("Vous recevrez bientôt un email contenant vos résultats. Pourquoi ne pas consulter vos précédents résultats (si vous avez déjà effectué le test auparavant) en attendant ?");
        })
    });
});