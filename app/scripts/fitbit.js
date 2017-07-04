// If user hasn't authed with Fitbit, redirect to Fitbit OAuth Implicit Grant Flow
var fitbitAccessToken;

var dev_token = "eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1VDc1UzgiLCJhdWQiOiIyMjhGWUgiLCJpc3MiOiJGaXRiaXQiLCJ0eXAiOiJhY2Nlc3NfdG9rZW4iLCJzY29wZXMiOiJyc29jIHJzZXQgcmFjdCBybG9jIHJ3ZWkgcmhyIHJudXQgcnBybyByc2xlIiwiZXhwIjoxNTMwNzEwNzQxLCJpYXQiOjE0OTkxODExOTJ9.u_H4JFHmFaPa7EyUBbZFOWW2BqIkPhlpNPy5Duy6FnA";

var isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

if (isLocal) {
    fitbitAccessToken = dev_token;
} else {
    if (!window.location.hash) {
        window.location.replace('https://www.fitbit.com/oauth2/authorize?response_type=token&client_id=228FYH&redirect_uri=https%3A%2F%2Fdawin.sylvainmetayer.fr%2F&scope=activity%20nutrition%20heartrate%20location%20nutrition%20profile%20settings%20sleep%20social%20weight');
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

function syntaxHighlight(json) {
    if (typeof json != 'string') {
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

function output(inp) {
    $("#result").html(inp);
}

// Make an API request and graph it
let processResponse = function (res) {
    if (!res.ok) {
        console.log(res);
        throw new Error('Fitbit API request failed: ' + res);
    }

    let contentType = res.headers.get('content-type');
    if (contentType && contentType.indexOf("application/json") !== -1) {
        return res.json();
    } else {
        throw new Error('JSON expected but received ' + contentType);
    }
};

let processHeartRate = function (jsonData) {
    console.log(jsonData);
    output(syntaxHighlight(jsonData));
};


function getData(url) {
    console.log(url);
    getFitbitData(url).then(processResponse)
        .then(processHeartRate)
        .catch(function (error) {
            console.log(error);
        });
}

function queryFitbit(url, type = "GET", token, callback) {
    $.ajax({
        type: type,
        beforeSend: function (request) {
            request.setRequestHeader("Authorization", 'Bearer ' + token);
        },
        crossDomain: true,
        url: url,
        dataType: "json",
        success: callback
    })
}

function getFitbitData(url) {
    return fetch(url, {
            headers: new Headers({
                'Authorization': 'Bearer ' + fitbitAccessToken
            }),
            mode: 'cors',
            method: 'GET'
        }
    );
}

var a = "";

function getProfileId(data) {
    var id = data.user.encodedId;
    // TODO Call API to set up session user id.
    $("#test_res").html(id);
}

function getFitbitProfileId() {
    const url = "https://api.fitbit.com/1/user/-/profile.json";
    queryFitbit(url, "GET", fitbitAccessToken, getProfileId);
}