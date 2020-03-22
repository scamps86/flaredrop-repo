/**
 * Data formatter utils
 */
function UtilsFormatterClass() {
}


/**
 * Format a value as a currency.
 *
 * @param value The value to be formatted
 * @param currency The currency. Euros by default
 *
 * @returns A value like: 13,50€
 */
UtilsFormatterClass.prototype.currency = function (value, currency) {

    // Set default currency
    currency = currency === undefined ? "&euro;" : currency;

    // Format the number
    value = parseFloat(value);
    var decimalPart;
    var array = Math.floor(value).toString().split('');
    var index = -3;
    while (array.length + index > 0) {
        array.splice(index, 0, '.');
        index -= 4;
    }

    decimalPart = value.toFixed(2).split(".")[1];
    return array.join('') + "," + decimalPart + currency;
};


/**
 * Pad a number on the left. For example: 001, 002..
 */
UtilsFormatterClass.prototype.padLeft = function (number, length) {
    var result = "" + number;

    while (result.length < length) {
        result = "0" + result;
    }
    return result;
};


/**
 * Set the decimal quantity on a number
 *
 * @param value The value to be formatted
 * @param decimals The number of decimals to apply
 *
 * @returns The formatted value
 */
UtilsFormatterClass.prototype.setDecimals = function (value, decimals) {
    return Number(Number(value).toFixed(decimals));
};


/**
 *Format a time like: 2d 13h 55m 60s
 *
 * @param value The value in seconds to be formatted
 * @param days The days symbol. "d " by default
 * @param hours The hours symbol. "h " by default
 * @param minutes The minutes symbol. "m " by default
 * @param seconds The seconds symbol. "s " by default
 * @param hideOnZero Hide the unit if it's 0. True by default
 *
 * @returns The formatted string
 */
UtilsFormatterClass.prototype.time = function (value, days, hours, minutes, seconds, hideOnZero) {

    var utils = this;

    var options = {
        days: days || "d ",
        hours: hours || "h ",
        minutes: minutes || "m ",
        seconds: seconds || "s"
    };

    hideOnZero = hideOnZero === undefined ? true : hideOnZero;

    days = Math.floor(value / 86400);
    hours = Math.floor((value - (days * 86400)) / 3600);
    minutes = Math.floor((value - (days * 86400) - (hours * 3600)) / 60);
    seconds = value - (days * 86400) - (hours * 3600) - (minutes * 60);

    if (days <= 0 && hideOnZero) {
        days = "";
    }
    else {
        days = '<span class="countdownDays">' + days + options.days + "</span>";
    }

    if (hours <= 0 && hideOnZero && days == "") {
        hours = "";
    }
    else {
        hours = '<span class="countdownHours">' + utils.padLeft(hours, 2) + options.hours + "</span>";
    }

    if (minutes <= 0 && hideOnZero && hours == "" && days == "") {
        minutes = "";
    }
    else {
        minutes = '<span class="countdownMinutes">' + utils.padLeft(minutes, 2) + options.minutes + "</span>";
    }

    if (seconds <= 0 && hideOnZero && minutes == "" && hours == "" && days == "") {
        seconds = "";
    }
    else {
        seconds = '<span class="countdownSeconds">' + utils.padLeft(seconds, 2) + options.seconds + "</span>";
    }

    return days + hours + minutes + seconds;
};