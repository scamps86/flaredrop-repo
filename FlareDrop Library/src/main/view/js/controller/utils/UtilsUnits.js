/**
 * Singleton Class that lets us convert units
 */
function UtilsUnitsClass() {
}


/**
 * Convert bytes to kilobytes
 *
 * @param bytes The bytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.bytesToKilobytes = function (bytes) {
    return UtilsFormatter.setDecimals(bytes / 1024, 2);
};


/**
 * Convert bytes to megabytes
 *
 * @param bytes The bytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.bytesToMegabytes = function (bytes) {
    return UtilsFormatter.setDecimals(bytes / 1048576, 2);
};


/**
 * Convert bytes to gigabytes
 *
 * @param bytes The bytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.bytesToGibabytes = function (bytes) {
    return UtilsFormatter.setDecimals(bytes / 1073741824, 2);
};


/**
 * Convert bytes to terabytes
 *
 * @param bytes The bytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.bytesToTerabytes = function (bytes) {
    return UtilsFormatter.setDecimals(bytes / 1099511627776, 2);
};


/**
 * Convert kilobytes to bytes
 *
 * @param kilobytes The kilobytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.kilobytesToBytes = function (kilobytes) {
    return kilobytes * 1024;
};


/**
 * Convert kilobytes to megabytes
 *
 * @param kilobytes The kilobytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.kilobytesToMegabytes = function (kilobytes) {
    return UtilsFormatter.setDecimals(kilobytes / 1024, 2);
};


/**
 * Convert kilobytes to gigabytes
 *
 * @param kilobytes The kilobytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.kilobytesToGigabytes = function (kilobytes) {
    return UtilsFormatter.setDecimals(kilobytes / 1048576, 2);
};


/**
 * Convert kilobytes to terabytes
 *
 * @param kilobytes The kilobytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.kilobytesToTerabytes = function (kilobytes) {
    return UtilsFormatter.setDecimals(kilobytes / 1073741824, 2);
};


/**
 * Convert megabytes to bytes
 *
 * @param megabytes The megabytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.megabytesToBytes = function (megabytes) {
    return megabytes * 1048576;
}


/**
 * Convert megabytes to kilobytes
 *
 * @param megabytes The megabytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.megabytesToKiloytes = function (megabytes) {
    return megabytes * 1024;
}


/**
 * Convert megabytes to gigabytes
 *
 * @param megabytes The megabytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.megabytesToGigabytes = function (megabytes) {
    return UtilsFormatter.setDecimals(megabytes / 1024, 2);
}


/**
 * Convert megabytes to terabytes
 *
 * @param megabytes The megabytes quantity
 *
 * @returns The converted unit
 */
UtilsUnitsClass.prototype.megabytesToTerabytes = function (megabytes) {
    return UtilsFormatter.setDecimals(megabytes / 1048576, 2);
}