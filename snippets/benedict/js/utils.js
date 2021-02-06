
function nl2br(str, is_xhtml) {
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function strEndsWith(str, substr) {
	return str.indexOf(substr, str.length - substr.length) !== -1;
}

function queryStringToJSON(queryString) {
	var pairs = "";
	pairs = queryString.slice(queryString.indexOf('?') + 1).split('&');

	var result = {};
	pairs.forEach(function(pair) {
		pair = pair.split('=');
		result[pair[0]] = decodeURIComponent(pair[1] || '');
	});

	return JSON.parse(JSON.stringify(result));
}

function deleteQueryStringFromUrl(url) {
	var end_pos = url.indexOf('?');
	if (end_pos > 0) {
		return url.substring(0, end_pos);
	}

	return url;

}

function getQueryStringFromUrl(url) {
	return url.substring(url.indexOf('?'));
}


function truncateStr(string, length) {
	if (string.length > length)
		return string.substring(0, length) + '...';
	else
		return string;
};

function getQueryStringValue(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function ucwords(str) {

	return (str + '').replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
		return $1.toUpperCase();
	});
}

function getNumberFromStr(str) {
	if (!isBlank(str)) {
		var numb = str.match(/\d/g);
		numb = numb.join("");
		return numb;
	}
}

function htmlEntities(htmlStr) {
	return $('<div/>').text(htmlStr).html();
}


function getHashFromUrl(url) {
	var hash = url.substring((url.indexOf('#') + 1));

	return hash;
}

function getHashFromWindowUrl() {
	var hash = window.location.hash.substring((window.location.hash.indexOf('#') + 1));
	return hash;
}

function jsonHasKey(jsonObj, key) {
	return jsonObj.hasOwnProperty(key);
}

function removeSpaces(str) {
	str = str.replace(/\s+/g, '');
	return str;
}

function elementHasAttribute(selector, attributeName) {
	var $element = null;
	if (selector instanceof jQuery) {
		$element = selector;
	} else {
		$element = $(selector);

	}
	var attr = $element.attr(attributeName);

	if (typeof attr !== typeof undefined && attr !== false) {
		return true;
	}

	return false;
}

function randomString(length) {
	var text = "";
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	for (var i = 0; i < length; i++) { text += possible.charAt(Math.floor(Math.random() * possible.length)); }


	return text;
}


