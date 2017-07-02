// If user hasn't authed with Fitbit, redirect to Fitbit OAuth Implicit Grant Flow
var fitbitAccessToken;

let login_url = "https://www.fitbit.com/oauth2/authorize?response_type=token&client_id=" + "228FYH" + " &redirect_uri=https%3A%2F%2Fsylvainmetayer.github.io%2Fsemaine-innovante-dawin%2F&scope=activity%20nutrition%20heartrate%20location%20nutrition%20profile%20settings%20sleep%20social%20weight";

var dev_token = "eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI1VDc1UzgiLCJhdWQiOiIyMjhGWUgiLCJpc3MiOiJGaXRiaXQiLCJ0eXAiOiJhY2Nlc3NfdG9rZW4iLCJzY29wZXMiOiJyc29jIHJzZXQgcmFjdCBybG9jIHJ3ZWkgcmhyIHJudXQgcnBybyByc2xlIiwiZXhwIjoxNTMwNTQ3NTgyLCJpYXQiOjE0OTkwMTE1ODJ9.mPjMJHRPcZFZBXb9kRRcZYqRR6jLf6uhIO18Rk_vUtE";

var isLocal = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1";

if (isLocal) {
    fitbitAccessToken = dev_token;
} else {
    if (!window.location.hash) {
        window.location.replace(login_url);
    } else {
        var fragmentQueryParameters = {};
        window.location.hash.slice(1).replace(
            new RegExp("([^?=&]+)(=([^&]*))?", "g"),
            function ($0, $1, $2, $3) {
                fragmentQueryParameters[$1] = $3;
            }
        );

        fitbitAccessToken = fragmentQueryParameters.access_token;
        console.log(fitbitAccessToken);
    }
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
};

fetch(
    'https://api.fitbit.com/1/user/-/activities/heart/date/today/1d.json',
    {
        headers: new Headers({
            'Authorization': 'Bearer ' + fitbitAccessToken
        }),
        mode: 'cors',
        method: 'GET'
    }
).then(processResponse)
    .then(processHeartRate)
    .catch(function (error) {
        console.log(error);
    });