/** Global application model */
function ModelApplicationClass() {

    // Declare this model
    var model = this;

    // Literals application bundle file
    model.bundle = "ManagerApp";

    // Application literals (ManagerLiterals)
    model.literals = new ManagerLiterals(UtilsConversion.jsonToObject(GLOBAL_MANAGER_LITERALS));

    // Application selected literal
    model.selectedLanTag = GLOBAL_CURRENT_LAN_TAG;

    // Application selected language
    model.selectedLanguage = GLOBAL_CURRENT_LANGUAGE;

    // Application selected module name
    model.selectedModuleName = "";

    // The server's disks
    model.disks = [];

    // User information
    model.user = {};

    // Set if the manager is configurable or not
    model.configurable = false;

    // Database used space in bytes
    model.dataBasePicturesUsedSpace = 0;
    model.dataBaseFilesUsedSpace = 0;

    // Define ajax timeouts in ms
    model.ajaxTimeOut = 30000; // Used to getting or setting text data in ms
    model.ajaxDataTimeOut = 500000; // Used when getting or setting binary data in ms

    // The configuration
    model.configuration = null;

    // Define the number of waiting processes. While this number is more than 0, a waiting window will be shown
    model.waitingProcessQuantity = 0;

    // Define the events
    model.EVENT_GET_DATA_SUCCESS = "EVENT_GET_DATA_SUCCESS"; // Event when the info for the application is successfully loaded from database
    model.EVENT_WINDOW_RESIZE = "EVENT_WINDOW_RESIZE"; // Event when the browser window is resized
    model.EVENT_GET_FILES_USED_SPACE_SUCCESS = "EVENT_GET_FILES_USED_SPACE_SUCCESS"; // Event when the db files used space is successfully getted
    model.EVENT_GET_PICTURES_USED_SPACE_SUCCESS = "EVENT_GET_PICTURES_USED_SPACE_SUCCESS"; // Event when the db images used space is successfully getted
    model.EVENT_MENU_CONFIGURATION_REMOVE = "EVENT_MENU_CONFIGURATION_REMOVE"; // Event when a configuration menu is successfully removed
    model.EVENT_OBJECT_CONFIGURATION_REMOVE = "EVENT_OBJECT_CONFIGURATION_REMOVE"; // Event when a configuration object is successfully removed
    model.EVENT_FILTER_CONFIGURATION_REMOVE = "EVENT_FILTER_CONFIGURATION_REMOVE"; // Event when a configuration filter is successfully removed
    model.EVENT_PROPERTY_CONFIGURATION_REMOVE = "EVENT_PROPERTY_CONFIGURATION_REMOVE"; // Event when a configuration property is successfully removed
    model.EVENT_LIST_CONFIGURATION_REMOVE = "EVENT_LIST_CONFIGURATION_REMOVE"; // Event when a configuration list is successfully removed
    model.EVENT_CSS_CONFIGURATION_REMOVE = "EVENT_CSS_CONFIGURATION_REMOVE"; // Event when a configuration CSS is successfully removed
    model.EVENT_VAR_CONFIGURATION_REMOVE = "EVENT_VAR_CONFIGURATION_REMOVE"; // Event when a global variable configuration is successfully removed
    model.EVENT_KEYBOARD_COPY = "EVENT_KEYBOARD_COPY"; // Event when the CTRL + C is pressed
    model.EVENT_KEYBOARD_PASTE = "EVENT_KEYBOARD_PASTE"; // Event when the CTRL + V is pressed
    model.EVENT_KEYBOARD_DELETE = "EVENT_KEYBOARD_DELETE"; // Event when the SUPR is pressed
    model.EVENT_KEYBOARD_SELECT_ALL = "EVENT_KEYBOARD_SELECT_ALL"; // Event when the CTRL + A is pressed

    // PayPal
    model.payPalBusiness = "";
    model.payPalSandboxEnabled = true;
    model.payPalBannerUrl = GLOBAL_URL_BASE_ABSOLUTE + "view/resources/images/_manager/payPalHeader.png";
    model.payPalServiceUrl = GLOBAL_URL_BASE_ABSOLUTE + "_webservice/SystemPayPalPlanRenew";
}