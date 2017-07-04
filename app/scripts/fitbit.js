// DEV
function syntaxHighlight(json) {
    if (typeof json !== 'string') {
        json = JSON.stringify(json, undefined, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}

function getData(url) {
    console.log(url);
    queryFitBit(url, "GET", fitbitAccessToken, _callbackLogData);
}

function _callbackLogData(jsonData) {
    console.log(jsonData);
    $("#result").html(syntaxHighlight(jsonData));
}

// END DEV

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
    // TODO Call API to set up session user id
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