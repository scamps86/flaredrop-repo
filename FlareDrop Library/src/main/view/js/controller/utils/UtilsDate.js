/**
 * Date utils
 */
function UtilsDateClass() {

    // Define this util
    var util = this;

    // Week day constants
    util.MONDAY = "MONDAY";
    util.TUESDAY = "TUESDAY";
    util.WEDNESDAY = "WEDNESDAY";
    util.THURSDAY = "THURSDAY";
    util.FRIDAY = "FRIDAY";
    util.SATURDAY = "SATURDAY";
    util.SUNDAY = "SUNDAY";

    // Month constants
    util.JANUARY = 'JANUARY';
    util.FEBRUARY = 'FEBRUARY';
    util.MARCH = 'MARCH';
    util.APRIL = 'APRIL';
    util.MAY = 'MAY';
    util.JUNE = 'JUNE';
    util.JULY = 'JULY';
    util.AUGUST = 'AUGUST';
    util.SEPTEMBER = 'SEPTEMBER';
    util.OCTOBER = 'OCTOBER';
    util.NOVEMBER = 'NOVEMBER';
    util.DECEMBER = 'DECEMBER';
}


/**
 * Create a new Javascript date object. If no year defined, it will return the current date
 *
 * @param year The custom year
 * @param month The custom month (1 to 12)
 * @param day The custom day
 * @param hour The custom hour
 * @param minute The custom minute
 * @param second The custom second
 *
 * @returns date The created javascript date object
 */
UtilsDateClass.prototype.create = function (year, month, day, hour, minute, second) {

    if (year === undefined) {
        return new Date();
    }

    month = month === undefined ? 0 : Number(month) - 1;
    day = day === undefined ? 1 : day;
    hour = hour === undefined ? 0 : hour;
    minute = minute === undefined ? 0 : minute;
    second = second === undefined ? 0 : second; // REVISAR 0s AL PHP

    return new Date(year, month, day, hour, minute, second);
};


/**
 * Convert a date to its timestamp
 *
 * @param dateObject The javascript date object
 *
 * @returns int   The timestamp
 */
UtilsDateClass.prototype.toTimestamp = function (dateObject) {
    return Math.round(parseInt(dateObject.getTime()) / 1000);
};


/**
 * Convert a javascript date object to a MySQL date
 *
 * @param dateObject The javascript date object
 *
 * @returns String
 */
UtilsDateClass.prototype.toMySQL = function (dateObject) {

    // Define this util
    var util = this;

    var mysqlDate = util.getYear(dateObject) + "-";
    mysqlDate += (util.getMonth(dateObject) < 10 ? "0" + util.getMonth(dateObject) : util.getMonth(dateObject)) + "-";
    mysqlDate += (util.getDay(dateObject) < 10 ? "0" + util.getDay(dateObject) : util.getDay(dateObject)) + " ";
    mysqlDate += (util.getHour(dateObject) < 10 ? "0" + util.getHour(dateObject) : util.getHour(dateObject)) + ":";
    mysqlDate += (util.getMinute(dateObject) < 10 ? "0" + util.getMinute(dateObject) : util.getMinute(dateObject)) + ":";
    mysqlDate += util.getSecond(dateObject) < 10 ? "0" + util.getSecond(dateObject) : util.getSecond(dateObject);

    return mysqlDate;
};


/**
 * Converts a MySQL string date to a Javascript date object. If the MySQL date is not correct, it will return a null object
 * @param mySQLDate The MySQL date as an string
 *
 * @returns date The Javascript date object
 */
UtilsDateClass.prototype.mySQLToDate = function (mySQLDate) {
    var util = this, dateParts = mySQLDate.split(" ");

    if (dateParts.length != 2) {
        return null;
    }

    var yearParts = dateParts[0].split("-"),
        timeParts = dateParts[1].split(":");

    // Verify the date string
    if (yearParts.length != 3 || timeParts.length != 3) {
        return null;
    }

    if (yearParts[0] < 1900 || yearParts[0] > 3000) {
        return null;
    }

    if (yearParts[1] < 1 || yearParts[1] > 12) {
        return null;
    }

    if (yearParts[2] < 1 || yearParts[2] > 31) {
        return null;
    }

    if (timeParts[0] < 0 || timeParts[0] > 23) {
        return null;
    }

    if (timeParts[1] < 0 || timeParts[1] > 59) {
        return null;
    }

    if (timeParts[2] < 0 || timeParts[2] > 59) {
        return null;
    }

    return util.create(yearParts[0], yearParts[1], yearParts[2], timeParts[0], timeParts[1], timeParts[2]);
};


/**
 * Convert a javascript date object to the format DD-MM-YYYY
 *
 * @param dateObject The javascript date object
 * @param glue The separator. "-" by default
 *
 * @returns String The formatted date
 */
UtilsDateClass.prototype.toDDMMYYYY = function (dateObject, glue) {

    // Define this util
    var util = this;

    glue = glue || "-";

    var date = "";
    date += util.getDay(dateObject) < 10 ? "0" + util.getDay(dateObject) : util.getDay(dateObject);
    date += glue;
    date += util.getMonth(dateObject) < 10 ? "0" + util.getMonth(dateObject) : util.getMonth(dateObject);
    date += glue + util.getYear(dateObject);

    return date;
};


/**
 * Convert a javascript date object to the format YYYY-MM-DD
 *
 * @param dateObject The javascript date object
 * @param glue The separator. "-" by default
 *
 * @returns String The formatted date
 */
UtilsDateClass.prototype.toYYYYMMDD = function (dateObject, glue) {

    // Define this util
    var util = this;

    glue = glue || "-";

    var date = "" + util.getYear(dateObject);
    date += glue;
    date += util.getMonth(dateObject) < 10 ? "0" + util.getMonth(dateObject) : util.getMonth(dateObject);
    date += glue;
    date += util.getDay(dateObject) < 10 ? "0" + util.getDay(dateObject) : util.getDay(dateObject);

    return date;
};


/**
 * Convert a formatted date like DD-MM-YYYY to a javascript date object. Hours, minutes and seconds will be defined as 0 by default
 *
 * @param date The formatted date
 * @param glue The separator used on the formatted date. "-" by default
 *
 * @returns date The Javascript date object
 */
UtilsDateClass.prototype.DDMMYYYYToDate = function (date, glue) {

    // Define this util
    var util = this;

    glue = glue || "-";

    var dateArr = date.split(glue);
    return util.create(dateArr[2], dateArr[1], dateArr[0]);
};


/**
 * Convert a formatted date like YYYY-MM-DD to a javascript date object. Hours, minutes and seconds will be defined as 0 by default
 *
 * @param date The formatted date
 * @param glue The separator used on the formatted date. "-" by default
 *
 * @returns date The javascript date object
 */
UtilsDateClass.prototype.YYYYMMDDToDate = function (date, glue) {

    // Define this util
    var util = this;

    glue = glue || "-";

    var dateArr = date.split(glue);
    return util.create(dateArr[0], dateArr[1], dateArr[2]);
};


/**
 * Add / substract on the current javascript date object
 *
 * @param period The period to be considered: YEAR, MONTH, DAY, HOUR, MINUTE, SECOND
 * @param dateObject The javascript date object
 * @param quantity The quantity of periods to add / substract. 1 by default
 * @param add Add or substract boolean. Add by default
 *
 * @returns date The resulting javascript date object
 */
UtilsDateClass.prototype.operate = function (period, dateObject, quantity, add) {

    // Define this util
    var util = this;

    quantity = quantity === undefined ? 1 : quantity;
    add = add === undefined ? true : add;
    var amount = add ? Number(quantity) : -Number(quantity);

    switch (period) {
        case "YEAR":
            dateObject.setFullYear(util.getYear(dateObject) + amount);
            break;
        case "MONTH":
            dateObject.setMonth((Number(util.getMonth(dateObject)) - 1) + amount);
            break;
        case "DAY":
            dateObject.setDate(util.getDay(dateObject) + amount);
            break;
        case "HOUR":
            dateObject.setHours(util.getHour(dateObject) + amount);
            break;
        case "MINUTE":
            dateObject.setMinutes(util.getMinute(dateObject) + amount);
            break;
        case "SECOND":
            dateObject.setSeconds(util.getSecond(dateObject) + amount);
            break;
    }

    return dateObject;
};


/**
 * Get the month name of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getMonthName = function (dateObject) {

    // Define this util
    var util = this;

    switch (util.getMonth(dateObject)) {
        case 1:
            return util.JANUARY;
        case 2:
            return util.FEBRUARY;
        case 3:
            return util.MARCH;
        case 4:
            return util.APRIL;
        case 5:
            return util.MAY;
        case 6:
            return util.JUNE;
        case 7:
            return util.JULY;
        case 8:
            return util.AUGUST;
        case 9:
            return util.SEPTEMBER;
        case 10:
            return util.OCTOBER;
        case 11:
            return util.NOVEMBER;
        case 12:
            return util.DECEMBER;
    }
};


/**
 * Get the week day name of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getDayName = function (dateObject) {

    // Define this util
    var util = this;

    switch (dateObject.getDay()) {
        case 0:
            return util.SUNDAY;
        case 1:
            return util.MONDAY;
        case 2:
            return util.TUESDAY;
        case 3:
            return util.WEDNESDAY;
        case 4:
            return util.THURSDAY;
        case 5:
            return util.FRIDAY;
        case 6:
            return util.SATURDAY;
    }
};


/**
 * Get the year of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getYear = function (dateObject) {
    return dateObject.getFullYear();
};


/**
 * Get the month of a current javascript date object. (from 1 to 12)
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getMonth = function (dateObject) {
    return Number(dateObject.getMonth()) + 1;
};


/**
 * Get how much days has the specified month
 *
 * @param dateObject The javascript date object
 *
 * @returns int
 */
UtilsDateClass.prototype.getMonthDaysQuantity = function (dateObject) {
    return Number(new Date(UtilsDate.getYear(dateObject), UtilsDate.getMonth(dateObject), 0).getDate());
};


/**
 * Get the day of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getDay = function (dateObject) {
    return dateObject.getDate();
};


/**
 * Get the week day number (0 to 6)
 *
 * @param dateObject The javascript date object
 *
 * @returns int
 */
UtilsDateClass.prototype.getWeekDay = function (dateObject) {
    var day = dateObject.getDay() - 1;

    if (day == -1) {
        day = 6;
    }
    return day;
};


/**
 * Get the hour of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getHour = function (dateObject) {
    return dateObject.getHours();
};


/**
 * Get the minute of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getMinute = function (dateObject) {
    return dateObject.getMinutes();
};


/**
 * Get the second of a current javascript date object
 *
 * @param dateObject The javascript date object
 *
 * @returns string
 */
UtilsDateClass.prototype.getSecond = function (dateObject) {
    return dateObject.getSeconds();
};


/**
 * Get the month info as an object:
 * {monthName : '...', days : [
 *     {dayName : '....', dayMonthNumber : (1-31), dayWeekNumber : (0-6)}, {...}, {...}
 * ]}
 *
 * @param dateObject The javascript date object
 */
UtilsDateClass.prototype.getFullMonthInfo = function (dateObject) {

    var result = {};

    // Set the month name
    result.monthName = UtilsDate.getMonthName(dateObject);
    result.days = [];

    for (var i = 1; i <= UtilsDate.getMonthDaysQuantity(dateObject); i++) {
        var dayDate = UtilsDate.create(UtilsDate.getYear(dateObject), UtilsDate.getMonth(dateObject), i);
        result.days.push({
            dayName: UtilsDate.getDayName(dayDate),
            dayMonthNumber: i,
            dayWeekNumber: UtilsDate.getWeekDay(dayDate)
        });
    }
    return result;
};