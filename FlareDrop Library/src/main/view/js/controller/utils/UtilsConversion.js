/**
 * Singleton Class that lets us encode and decode to base64.
 */
function UtilsConversionClass() {

    /** Private property */
    this._keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

}


/**
 * Encode an string to base64
 *
 * @param string The non base64 encoded string
 *
 * @returns {String}
 */
UtilsConversionClass.prototype.base64Encode = function (string) {

    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;

    string = this.utf8Encode(string);

    while (i < string.length) {

        chr1 = string.charCodeAt(i++);
        chr2 = string.charCodeAt(i++);
        chr3 = string.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        }
        else if (isNaN(chr3)) {
            enc4 = 64;
        }

        output = output + this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) + this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

    }

    return output;

};


/**
 * Decode an string from base64
 *
 * @param string The base64 encoded string
 *
 * @returns {String}
 */
UtilsConversionClass.prototype.base64Decode = function (string) {

    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    string = string.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    while (i < string.length) {

        enc1 = this._keyStr.indexOf(string.charAt(i++));
        enc2 = this._keyStr.indexOf(string.charAt(i++));
        enc3 = this._keyStr.indexOf(string.charAt(i++));
        enc4 = this._keyStr.indexOf(string.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }

    }

    output = this.utf8Decode(output);

    return output;

};


/**
 * Encode an string to UTF8
 *
 * @param string The non UTF8 encoded string
 *
 * @returns {String}
 */
UtilsConversionClass.prototype.utf8Encode = function (string) {

    string = string.replace(/\r\n/g, "\n");
    var utftext = "";

    for (var n = 0; n < string.length; n++) {

        var c = string.charCodeAt(n);

        if (c < 128) {
            utftext += String.fromCharCode(c);
        }
        else if ((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
        }
        else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
        }

    }

    return utftext;

};


/**
 * Decode an string from UTF8
 *
 * @param string The UTF8 encoded string
 *
 * @returns {String}
 */
UtilsConversionClass.prototype.utf8Decode = function (string) {

    var noUtfText = "";
    var i = 0;
    var c = c1 = c2 = 0;

    while (i < string.length) {

        c = string.charCodeAt(i);

        if (c < 128) {
            noUtfText += String.fromCharCode(c);
            i++;
        }
        else if ((c > 191) && (c < 224)) {
            c2 = string.charCodeAt(i + 1);
            noUtfText += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        }
        else {
            c2 = string.charCodeAt(i + 1);
            c3 = string.charCodeAt(i + 2);
            noUtfText += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }

    }

    return noUtfText;

};


/**
 * Convert a json string to javascript object. If the input string is not valid, it will return a null object
 *
 * @param jsonString The input string
 *
 * @returns object
 */
UtilsConversionClass.prototype.jsonToObject = function (jsonString) {

    if (!UtilsValidation.isJson(jsonString)) {
        return null;
    }

    return JSON.parse(jsonString);
};


/**
 * Convert a javascript object to a json string
 *
 * @param object The input object or array
 *
 * @returns string
 */
UtilsConversionClass.prototype.objectToJson = function (object) {
    return JSON.stringify(object);
};