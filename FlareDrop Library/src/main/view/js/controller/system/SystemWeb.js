/*
 * System web class
 */
function SystemWebClass() {

}


/*
 * Initialize the section javascript. (SECTION_NAME must be previously defined on the section PHP script or PHP header)
 *
 * @param sectionFileName The section PHP file name that we want to execute (without the .php extension))
 *
 * @param callbackFunction The function executed for the defined section
 */
SystemWebClass.prototype.initializeSectionJs = function (sectionFileName, callbackFunction) {
    if (typeof SECTION_NAME !== "undefined") {
        if (SECTION_NAME == sectionFileName) {
            callbackFunction.apply();
        }
    }
};