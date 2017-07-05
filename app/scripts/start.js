var shallContinue = true
var F0;
var F1;
var F2;
var F0_date;
var F1_date;
var F2_date;
var startButton = $('#startRuffier');
var startInterval;
var exerciseInterval;

startButton.click(function(){
    startButton.hide();
    $('#title-test').hide();
    F0_date = new Date().getDate();
    $('#cardiacRythmAtStart').hide();
    $('#testRuffier').show();
    $('#actualTest').hide();

    startInterval = setInterval(function(){
        var timer = $('#timerBeforeStart');
        var timerValue = parseInt(timer.text());
        timer.text(timerValue - 1);
        if(timerValue == 0){
            var startTime = new Date().getTime();
            $('#countDown1').hide();
            $('#actualTest').show();
            exerciseInterval = setInterval(function(){
                var actualTime = new Date().getTime();
                $('#testTimer').text(Math.floor((actualTime - startTime)/1000));
            }, 1000)
        }
    }, 1000);
})

$('#endExercise').click(function(){
    
    clearInterval(startInterval);
    clearInterval(exerciseInterval);
    $('#actualTest').hide();
    $('#afterTest').show();

    var cpt = 0;
    var getRequiredDateInterval = setInterval(function(){
        cpt = cpt+1;
        if(cpt == 15){
            F1_date = new Date().getTime();
            alert(F1_date);
        }
        else if(cpt == 75){
            F2_date = new Date().getTime();
            alert(F2_date);
        }
        else if(cpt >= 76){
            clearInterval(getRequiredDateInterval);
        }
    }, 1000) 
})