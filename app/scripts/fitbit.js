function authenticateUser() {
    if (cfg.localhost) {
        fitbitAccessToken = cfg.dev_token;
    } else {
        if (!window.location.hash) {
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
        if (cfg.localhost) {
            $("#url_api").val(cfg.dev_default_query);
        }
    }
});