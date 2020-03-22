/** Value validation utils */
function UtilsValidationClass() {
}


/**
 * Validate if the input value is a-z, A-Z, 0-9
 *
 * @param value Input value to be validated
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isDefault = function (value) {

    if (value == "") {
        return false;
    }

    var pattern = /[^a-zA-Z0-9]/;
    return !pattern.test(value);

};


/**
 * Validate if the input value is an email
 *
 * @param value Input value to be validated
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isEmail = function (value) {

    var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    return pattern.test(value);

};


/**
 * Validate if the input value is a phone number
 *
 * @param value Input value to be validated
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isPhone = function (value) {

    if (value.length > 4 && value.length <= 20) {

        var correctChars = "+- 1234567890()";

        for (var i = 0; i < value.length; i++) {

            var c = value.charAt(i);

            if (correctChars.indexOf(c) < 0) {
                return false;
            }
        }
        return true;
    }
    return false;

};


/**
 * Validate if the input value is filled
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isFilled = function (value) {

    var pattern = /\S/;
    return pattern.test(value);

};


/**
 * Validate if the input value is an +-integer number
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isInteger = function (value) {

    var pattern = /^\s*(\+|-)?\d+\s*$/;
    return pattern.test(value);

};


/**
 * Validate if the input value is a natural number
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isNumberNatural = function (value) {

    if (isNaN(value)) {
        return false;
    }

    return value >= 0 && Math.floor(value) === +value;

};


/**
 * Validate if the input value is a number
 *
 * @param value The input value
 *
 * @returns Boolean validation success or failure
 */
UtilsValidationClass.prototype.isNumber = function (value) {
    return !isNaN(value);
};


/**
 * Validate if the input value is a date dd/mm/yyyy
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or faliure
 */
UtilsValidationClass.prototype.isDateDMY = function (value) {

    var period = [1900, 3000];

    if (value.length != 10) {
        return false;
    }

    value = value.split("/");

    if (value.length != 3) {
        return false;
    }

    if (isNaN(value[0]) || isNaN(value[1]) || isNaN(value[2])) {
        return false;
    }

    if (value[0].length != 2 || value[1].length != 2 || value[2].length != 4) {
        return false;
    }

    if (value[0] < 1 || value[0] > 31) {
        return false;
    }

    if (value[1] < 1 || value[1] > 12) {
        return false;
    }

    if (value[2] < period[0] || value[2] > period[1]) {
        return false;
    }

    return true;

};


/**
 * Validate if the input value is a DNI
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isDni = function (value) {

    var pattern = /^\d{8}[a-zA-Z]$/;

    if (pattern.test(value) == true) {

        var num = value.substr(0, value.length - 1);
        var c = value.substr(value.length - 1, 1);
        var cc = 'TRWAGMYFPDXBNJZSQVHLCKET';

        num = num % 23;
        cc = cc.substring(num, num + 1);

        if (cc == c.toUpperCase()) {
            return true;
        }
    }
    return false;
};


/**
 * Validate if the input value is a password. At least 6 characters, one number, one lowercase and one uppercase letter
 *
 * @param value The input value
 *
 * @returns Boolean Validation success or failure
 */
UtilsValidationClass.prototype.isPassword = function (value) {
    var pattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    return pattern.test(value);
};


/**
 * It checks if an string is a JSON string
 *
 * @param jsonString The input string that should be a JSON
 *
 * @returns {Boolean}
 */
UtilsValidationClass.prototype.isJson = function (jsonString) {
    try {
        JSON.parse(jsonString);
    } catch (e) {
        return false;
    }
    return true;
};