function authenticateUser() {
    if (cfg.localhost) {
        fitbitAccessToken = cfg.dev_token;
    } else {
        if (!window.location.hash) {
            alert("First, you need to connect your FitBit account");
            // TODO Replace this alert with a modal window
            window.location.replace(cfg.auth_url);
        } else {
            var fragmentQueryParameters = {};
            window.location.hash.slice(1).replace(
                new RegExp("([^?=&]+)(=([^&]*))?", "g"),
                function ($0, $1, $2, $3) {
                    fragmentQueryParameters[$1] = $3;
                }
            );

            fitbitAccessToken = fragmentQueryParameters.access_token;
        }
    }
    getFitbitProfileId();
}

function getFitbitProfileId() {
    const url = cfg.base_url + "1/user/-/profile.json";
    queryFitBit(url, "GET", fitbitAccessToken, _callbackProfileID);
}

function getHR_atDate(hour) {
    const url = cfg.base_url + "1/user/-/activities/heart/date/today/1d/1sec/time/05:50/05:51.json";
    cfg.hour = hour;
    queryFitBit(url, "GET", fitbitAccessToken, function (data) {
        _callbackHR_atTime(data, hour);
    })
}

function queryFitBit(url, type = "GET", token, callback) {
    $.ajax({
        type: type,
        beforeSend: function (request) {
            request.setRequestHeader("Authorization", 'Bearer ' + token);
        },
        crossDomain: true,
        url: url,
        dataType: "json"
    }).done(callback).fail(function (err) {
        console.log(err);
    })
}

function _callbackProfileID(data) {
    cfg.user_id = data.user.encodedId;
}

function _callbackHR_atTime(data, hour) {
    var heart_rates;
    heart_rates = data["activities-heart-intraday"].dataset;
    var second_objective = parseInt(hour.split(":")[2]);
    var minDiff = 60;
    var value = "";

    heart_rates.forEach(function (e) {
        var tmp_sec = parseInt(e.time.split(":")[2]);
        if (tmp_sec > second_objective) {
            if (tmp_sec - second_objective < minDiff) {
                minDiff = tmp_sec - second_objective;
                value = e.time;
            }
        } else {
            if (second_objective - tmp_sec < minDiff) {
                minDiff = second_objective - tmp_sec;
                value = e.time;
            }
        }
    });

    console.log("The data is " + value);
    console.log(findByHour(value, heart_rates));
}

function findByHour(hour, array) {
    function seuil(element) {
        return element.time === hour;
    }

    return array.find(seuil);
}

var fitbitAccessToken;

var cfg = {};
const config_url = location.protocol + '//' + location.host + "/config.json";
$.ajax({
    url: config_url,
    dataType: "json",
    success: function (data) {
        cfg = data;
        API.url = cfg.base_api_url;
        authenticateUser();
        if (cfg.localhost)
            $("#url_api").val(cfg.dev_default_query);
    }
});