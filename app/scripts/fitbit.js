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

function getHR_atDate(hour, variable) {
    var str_hour = parseInt(hour.split(":")[0]);
    var str_hour_next = str_hour;
    var str_min = parseInt(hour.split(":")[1]);
    var str_min_next = str_min + 1;
    if (str_min_next >= 60) {
        str_min_next = 0;
        str_hour_next += 1;
    }
    const hr_url = "1/user/-/activities/heart/date/today/1d/1sec/time/";
    const url = cfg.base_url + hr_url + str_hour + ":" + str_min + "/" + str_hour_next + ":" + str_min_next + ".json";
    cfg.hour = hour;
    queryFitBit(url, "GET", fitbitAccessToken, function (data) {
        _callbackHR_atTime(data, hour, variable);
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

function _callbackHR_atTime(data, hour, variable) {
    var heart_rates;
    heart_rates = data["activities-heart-intraday"].dataset;
    var second_objective = parseInt(hour.split(":")[1]) * 60 + parseInt(hour.split(":")[2]);
    var minDiff = 3600;
    var value = "";

    heart_rates.forEach(function (e) {
        var tmp_sec = parseInt(e.time.split(":")[1]) * 60 + parseInt(e.time.split(":")[2]);
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

    variable.hr = findByHour(value, heart_rates).value;
    return variable;
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