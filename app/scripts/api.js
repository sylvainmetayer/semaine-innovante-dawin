var API = API || {};

(function (self) {

	console.log("API is loaded");

	function getXMLHttpRequest() {
		var xhr = null;
		if (window.XMLHttpRequest || window.ActiveXObject) {
			if (window.ActiveXObject) {
				try {
					xhr = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}
			} else if (window.XDomainRequest) {
				console.log("XDomain allow");
				xhr = new XDomainRequest();
			} else {
				xhr = new XMLHttpRequest();
			}
		} else {
			alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
			return null;
		}

		return xhr;
	}

	function stringify(obj) {

		var string = "";

		for (var prop in obj) {
			string += prop + "=" + obj[prop] + "&";
		}

		if (string != "") {
			string = string.slice(0, -1);
		}

		return string;
	}

	function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

	function request(callback, post, get) {
		var xhr = getXMLHttpRequest();


		xhr.onreadystatechange = function () {
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				var json = "";
				try {
			        json = JSON.parse(xhr.responseText);
			    } catch (e) {
			    	console.log("Invalid JSON")
			    }

			    callback(json);
			}
		};

		xhr.open("POST", self.url + "?" + stringify(get), true);

		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		
		xhr.send(stringify(post));
	}

	self.url = "";

	self.request = function (controller, action) {

		var route = {
			controller: controller,
			action: action
		};

		return {
			route: route,
			form: function form(params) {
				return {
					route: route,
					params: params,
					send: function send(callback) {
						request(callback, params, route);
					}
				};
			}
		};
	};

	return self;
})(API);