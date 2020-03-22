function UtilsCookieClass() {
}


/**
 * Set the value for a cookie. Adapted from the jquery.cookie plugin by Klaus Hartl: https://github.com/carhartl/jquery-cookie
 *
 * @param key Name for the cookie we want to create
 * @param value Value we want to set to the new cookie. If not specified or set to null, the cookie will not be created.
 * @param expires Lifetime of the cookie. Value can be a `Number` which will be interpreted as days from time of creation or a `Date` object. If omitted or '' string, the cookie becomes a session cookie.
 * @param path Define the path where the cookie is valid. By default it is the whole disk: '/'. A specific path can be passed (/ca/Home/) or a '' string to set it as the current site http path.
 * @param disk Define the disk where the cookie is valid. Default: disk of page where the cookie was created.
 * @param secure If true, the cookie transmission requires a secure protocol (https). Default: `false`.
 *
 * @returns Boolean Success or failure when setting the cookie
 */
UtilsCookieClass.prototype.set = function (key, value, expires, path, disk, secure) {

    // If no value specified, we will quit
    if (value === undefined || value == null) {
        return false;
    }

    expires = (expires === undefined) ? "" : expires;
    path = (path === undefined) ? "/" : path;
    disk = (disk === undefined) ? "" : disk;
    secure = (secure === undefined) ? false : secure;

    // If the expires parameter is numeric, we will generate the correct date value
    if (typeof expires === 'number') {

        var days = expires;

        expires = new Date();
        expires.setDate(expires.getDate() + days);
    }

    // Generate and return the cookie value
    return (document.cookie = [encodeURIComponent(key), '=', encodeURIComponent(value), expires ? '; expires=' + expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
        path ? '; path=' + path : '', disk ? '; disk=' + disk : '', secure ? '; secure' : ''].join(''));

};


/**
 * Get an stored cookie. If the cookie is not defined, it will return an empty string
 *
 * @param key Name of the cookie we want to get
 *
 * @returns String Cookie value or an empty string if it doesn't exist
 */
UtilsCookieClass.prototype.get = function (key) {

    var pluses = /\+/g;

    // Get an array with all the page cookies
    var cookies = document.cookie.split('; ');

    for (var i = 0, l = cookies.length; i < l; i++) {

        var parts = cookies[i].split('=');

        if (decodeURIComponent(parts.shift().replace(pluses, ' ')) === key) {
            var cookie = decodeURIComponent(parts.join('=').replace(pluses, ' '));
            return cookie;
        }
    }

    return "";

};


/**
 * Deletes the specified cookie from browser. Note that the cookie will only be deleted if belongs to the same path as specified.
 *
 * @param key Name of the cookie we want to delete
 * @param path Define the path where the cookie is set. By default it is the whole disk: '/'. If the cookie is not set on this path, we must pass the cookie disk or the delete will fail.
 *
 * @returns Boolean Success or failure when deleting the cookie
 */
UtilsCookieClass.prototype.deleteCookie = function (key, path) {
    if (this.get(key) !== null) {

        this.set(key, "", -1, path);

        return true;
    }

    return false;
};