var startDate;
var $startButton = $('#startRuffier');
var startInterval;
var exerciseInterval;
var timerInterval;

toastr.options.closeButton = true;
toastr.options.timeOut = 5000;
toastr.options.extendedTimeOut = 10000;

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
            startDate = new Date();
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

    timerInterval = setInterval(function () {
        var timer = $('#rest-timer');
        var timerValue = parseInt(timer.text());
        timer.text(timerValue - 1);
        if (timerValue <= 0) {
            timer.text(0);
            clearInterval(timerInterval);
            $("#sync-fitbit").show();
            toastr.warning("Pensez à synchroniser votre fitbit !");
        }
    }, 1000);

    const endTime = new Date();

    $("#submitEmail").click(function () {
        const email = $("#email").val();
        if (email === "") {
            toastr.error("Votre email ne peut pas être vide !");
            return;
        }

        const form = {
            "email": email,
            "startTime": getStringDate(startDate),
            "endTime": getStringDate(endTime),
            "userID": cfg.user_id,
            "token": fitbitAccessToken
        };

        API.request("email", "addToCron").form(form).send(function (json) {
            // TODO check if mail was correct
            toastr.success('Vous recevrez bientôt un email contenant vos résultats.');
            toastr.info("Vous pouvez consulter ci-dessous vos précédents résultats, si vous avez déjà effectué le test");
            $("#mail").remove();

            API.request("result", "selectResult").form({
                "id_user_fitbit": cfg.user_id
            }).send(function (json) {
                json.forEach(function (e) {
                    let li = $("<li>");
                    let text = "Le " + e.date + ", premier HR : " + e.first_hr;
                    text += ", 2ème HR :" + e.second_hr + " et 3ème HR : " + e.third_hr;
                    text += ". Cela vous donne un résultat de Ruffier de " + getRuffier(e.first_hr, e.second_hr, e.third_hr);
                    li.html(text);
                    $("#previousTest").append(li);
                });
            });
        })
    });
});