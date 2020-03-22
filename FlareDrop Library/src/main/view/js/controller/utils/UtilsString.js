function UtilsStringClass() {
}


/**
 * Count the number of repeats of a character/s in a string
 *
 * @param string The full string
 * @param repeat The string to be searched
 *
 * @returns The number of repeats
 */
UtilsStringClass.prototype.countRepeats = function (string, repeat) {
    // Return the number of repeats
    return string.split(repeat).length;
};


/**
 * Encode an html string to be printed as text
 *
 * @param string The input string
 *
 * @returns The encoded string
 */
UtilsStringClass.prototype.htmlSpecialChars = function (string) {
    if (typeof(string) == "string") {
        string = string.replace(/&/g, "&amp;");
        string = string.replace(/"/g, "&quot;");
        string = string.replace(/'/g, "&#039;");
        string = string.replace(/</g, "&lt;");
        string = string.replace(/>/g, "&gt;");
    }
    return string;
};