$(document).ready(function () {
    $('#sub').click(function () {
        var url = $('#url_api').val();
        getData(url);
    });

    var startButton = $('#startRuffier');
    startButton.click(function () {
        startButton.hide();
        $('#cardiacRythmAtStart').show();
    });

    var shallContinue = true;

    $('#endExercise').click(function () {
        shallContinue = false;
    });

    $('#validate1').click(function () {
        $('#cardiacRythmAtStart').hide();
        $('#testRuffier').show();
        $('#actualTest').hide();

        setInterval(function () {
            var timer = $('#timerBeforeStart');
            var timerValue = parseInt(timer.text());
            timer.text(timerValue - 1);
            if (timerValue === 0) {
                clearInterval();
                var startTime = new Date().getTime();
                $('#countDown1').hide();
                $('#actualTest').show();
                setInterval(function () {
                    var actualTime = new Date().getTime();
                    $('#testTimer').text(Math.floor((actualTime - startTime) / 1000));
                    if (!shallContinue)
                        clearInterval();
                }, 1000)
            }
        }, 1000);
    });

});