function UtilsHttpClass() {
}


/**
 * Generate the URL parameters encoded string. Not obfuscated because of javascript can be viewed by hackers
 * All services that are getting this encoded params should consider that they are not obfuscated
 *
 * @param params The object {key1 : value, key1 : value2, ...}
 *
 * @returns string The encoded parameters string
 */
UtilsHttpClass.prototype.encodeParams = function (params) {
    return UtilsConversion.base64Encode(UtilsConversion.objectToJson(params));
};


/**
 * Go to a relative or full url
 *
 * @param url The relative or full url
 * @param newTab open url in a new tab. False by default
 */
UtilsHttpClass.prototype.goToUrl = function (url, newTab) {
    if (newTab) {
        window.open(url, "_blank");
    }
    else {
        window.location = url;
    }
};


/**
 * Refresh the page
 */
UtilsHttpClass.prototype.refresh = function () {
    location.reload();
};