// ==UserScript==
// @name           HN Crunch
// @namespace      http://syskall.com
// @description    This script replace HN users who have their own CrunchBase entry by a profile picture.
// @include        http://news.ycombinator.com/*
// ==/UserScript==

var backend_url = "http://your-domain.com/hn/hn.php";

var anchors = document.getElementsByTagName('a');

for(var i in anchors) {
    //console.log(anchors[i].href);
    if (anchors[i].href.substr(0,36) == 'http://news.ycombinator.com/user?id=') {
        var user_id = anchors[i].href.substr(36, anchors[i].href.length - 36);
		console.log("Looking up " + user_id);
		(function(a_element) {
			GM_xmlhttpRequest({
				method: 'GET',
				url: backend_url + '?user_id=' + user_id,
				onload: function(response) {
				    if(response.status == 200 && response.statusText == 'OK' && response.responseText != '') {
						var ele = document.createElement('span');
						ele.innerHTML = response.responseText;
						a_element.parentNode.insertBefore(ele, a_element.nextSibling);
						console.log(response.responseText);
					}
				}
			});       
		})(anchors[i]);
    }
}
