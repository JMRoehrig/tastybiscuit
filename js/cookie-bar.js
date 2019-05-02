jQuery(document).ready(function($) {
	if(!cookieBarReadCookie("cookieBarCookiesAccept")){
		$("#cookie-bar-wp").show();
	}
});


function cookieBarSetCookie(cookieName, cookieValue, nDays) {
	var today = new Date();
	var expire = new Date();
	if (nDays == null || nDays==0) nDays = 1;
	expire.setTime(today.getTime() + 3600000 * 24 * nDays);
	document.cookie = cookieName + "=" + escape(cookieValue) + ";expires=" + expire.toGMTString() + "; path=/";
}


function cookieBarReadCookie(cookieName) {
	var theCookie=" " + document.cookie;
	var ind = theCookie.indexOf(" " + cookieName + "=");
	if (ind == -1) ind = theCookie.indexOf(";" + cookieName + "=");
	if (ind == -1 || cookieName=="") return "";
	var ind1 = theCookie.indexOf(";", ind + 1);
	if (ind1 == -1) ind1 = theCookie.length; 
	return unescape(theCookie.substring(ind + cookieName.length + 2, ind1));
}


function cookieBarAcceptCookiesWP() {
	cookieBarSetCookie('cookieBarCookiesAccept', true, 365);
	jQuery("#cookie-bar-wp").hide();
	jQuery("html").css("margin-top","0"); /* Why is this line here? Looks like legacy that can be removed. */
}