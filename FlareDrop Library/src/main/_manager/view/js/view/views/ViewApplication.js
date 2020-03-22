//Define global variables and initialize the app
var ViewApplication = null;
var ModelApplication = null;
var ControlApplication = null;


$(document).ready(function () {
    // Initialize the application
    SystemWeb.initializeSectionJs("_manager", function () {
        // Initialize the application model
        ModelApplication = new ModelApplicationClass();

        // Initialize the application control
        ControlApplication = new ControlApplicationClass();

        // Initialize the application view when the application data is loaded
        ManagerEvent.addEventListener(ControlApplication, ModelApplication.EVENT_GET_DATA_SUCCESS, function () {

            if ($("#viewLogin").length > 0) {
                // Initialize the login view
                new ViewLoginClass();
            }

            if ($("#viewMain").length > 0 && ViewApplication == null) {
                // Initialize the used space for the home
                ControlApplication.getFilesUsedSpace();
                ControlApplication.getPicturesUsedSpace();

                // Initialize the application view
                ViewApplication = new ViewApplicationClass();
            }
        });
    });
});


/** LOGIN VIEW CLASS */
function ViewLoginClass() {

    // Declare this view
    var view = this;

    // Declare user credentials to be stored on the cookie
    view.userCredentials = "";
    view.userCredentialsCookie = "userCredentialsCookie";

    // CREATE THE MAIN ELEMENTS
    // Create the form
    var loginForm = $("<form></form>");

    $(loginForm).attr({
        "id": "lf",
        "serviceUrl": GLOBAL_URL_WEB_SERVICE_BASE + "UserLogin"
    });

    // Create the user label
    var pUser = $('<p id="pUser">' + ModelApplication.literals.get("USER", "ManagerApp") + "</p>");
    $(pUser).addClass("fontLight");

    // Create the user input
    view.inputUser = $("<input autofocus>");

    $(view.inputUser).attr({
        "type": "text",
        "name": "xLOG1",
        "maxlength": "15",
        "validate": "fill",
        "validateErrorMessage": ModelApplication.literals.get("LOGIN_ERROR", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp")
    });

    // Create the password label
    var pPassword = $("<p>" + ModelApplication.literals.get("PASSWORD", "ManagerApp") + "</p>");
    $(pPassword).addClass("fontLight");

    // Create the password input
    view.inputPassword = $("<input >");

    $(view.inputPassword).attr({
        "type": "password",
        "name": "xLOG2",
        "maxlength": "15",
        "validate": "password",
        "validateErrorMessage": ModelApplication.literals.get("LOGIN_ERROR", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp")
    });

    // Create remember input
    view.inputRemember = $('<div id="inputRemember"></div>');
    view.rememberSwitch = new ComponentSwitch(view.inputRemember, UtilsCookie.get(this.userCredentialsCookie) != "");

    $(view.inputRemember).append('<p class="fontLight">' + ModelApplication.literals.get("REMEMBER", "ManagerApp") + "</p>");

    // Create the login button
    var inputSubmit = $("<input >");

    $(inputSubmit).attr({
        "type": "submit",
        "id": "inputSubmit",
        "value": ModelApplication.literals.get("LOGIN", "ManagerApp")
    });

    // Create the literal chooser
    var literalChanger = new ComponentLocaleChanger();

    // Create the flareDrop icon
    var icon = $('<a id="flareDropLogo" href="http://www.flaredrop.com" target="_blank"><img src="' + GLOBAL_URL_BASE + 'view/resources/images/_manager/flareDropGrey.svg" alt="FlareDrop Development"><span>© 2015 FlareDrop. All Rights Reserved</span></a>');

    // APPEND THE OBJECTS AND SHOW THE LOGIN FORM
    $(loginForm).append(pUser, view.inputUser, pPassword, view.inputPassword, view.inputRemember, inputSubmit, literalChanger.container, icon);
    var _viewLogin = $("#viewLogin");
    $(_viewLogin).append(loginForm);
    $(_viewLogin).fadeIn(400);

    // Fill the login form only if the fields are stored to the browser cookies
    var loginFormCookie = UtilsConversion.base64Decode(UtilsCookie.get(this.userCredentialsCookie));

    if (loginFormCookie != "") {

        loginFormCookie = loginFormCookie.split(";");
        $(view.inputUser).val(loginFormCookie[0]);
        $(view.inputPassword).val(loginFormCookie[1]);

    }

    // ADD LOGIN FORM EVENT LISTENERS
    ManagerForm.add(loginForm, function () {

        view._onLoginSuccessHandler();
    }, function () {

        view._onLoginFailureHandler();
    }, function () {

        view._onLoginProcess();
    }, function () {

    });
}


/**
 * Private method called before sending the user login request
 */
ViewLoginClass.prototype._onLoginProcess = function () {

    // Define this view
    var view = this;

    // Set the user credentials to be stored to the cookie
    view.userCredentials = UtilsConversion.base64Encode($(view.inputUser).val() + ";" + $(view.inputPassword).val());

    // Store/remove user credentials to a browser's cookie
    if (view.rememberSwitch.isOpened()) {

        UtilsCookie.set(view.userCredentialsCookie, view.userCredentials, 365);
    }
    else {

        UtilsCookie.deleteCookie(view.userCredentialsCookie);
    }

    // Set cursor as waiting
    ManagerCursor.setState("wait");
};


/**
 * Private method called when the user login success
 */
ViewLoginClass.prototype._onLoginSuccessHandler = function () {

    // Redirect to the main app section
    UtilsHttp.goToUrl(GLOBAL_URL_MANAGER_APP);
};


/**
 * Private method called when the user login failure
 */
ViewLoginClass.prototype._onLoginFailureHandler = function () {

    ManagerCursor.setState();
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("LOGIN_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });

};


/** MAIN VIEW CLASS */
function ViewApplicationClass() {

    // Declare this view
    var view = this;

    // DEFINE TOPBAR ELEMENTS
    // Create topbar elements
    view.topBar = $('<div class="row unselectable" id="topBar"></div>'); // TopBar element container
    view.topBarLeft = $('<div id="topBarLeft"></div>');
    view.topBarMiddle = $('<div id="topBarMiddle"></div>');
    view.topBarRight = $('<div id="topBarRight"></div>');
    view.topBarMenuBtn = $('<a class="skinIcon topBarBtn" id="topBarMenuBtn"></a>');
    view.topBarCssBtn = $('<a class="skinIcon topBarBtn" id="topBarCssBtn"></a>');
    view.topBarVarBtn = $('<a class="skinIcon topBarBtn" id="topBarVarBtn"></a>');
    view.topBarHomeBtn = $('<a class="skinIcon topBarBtn" id="topBarHomeBtn"></a>');
    view.topBarLogoutBtn = $('<a class="skinIcon topBarBtn" id="topBarLogoutBtn"></a>');
    view.topBarConfigureBtn = $('<a class="skinIcon topBarBtn" id="topBarConfigureBtn"></a>');
    view.topBarUserIcon = $('<div class="skinIcon" id="topBarUserIcon"></div>');
    view.topBarUser = $('<p id="topBarUser"></p>');

    // Define the tooltips for the necessary top bar options
    $(view.topBarCssBtn).attr("title", ModelApplication.literals.get("CUSTOMIZE_WEBSITE_CSS", "ManagerApp"));
    $(view.topBarVarBtn).attr("title", ModelApplication.literals.get("GLOBAL_WEBSITE_VARIABLES", "ManagerApp"));
    $(view.topBarLogoutBtn).attr("title", ModelApplication.literals.get("USER_LOGOUT", "ManagerApp"));

    // Do the appends
    $(view.topBar).append(view.topBarLeft, view.topBarMiddle, view.topBarRight);
    $(view.topBarLeft).append(view.topBarMenuBtn, view.topBarCssBtn, view.topBarVarBtn, view.topBarHomeBtn);
    $(view.topBarRight).append(view.topBarUserIcon, view.topBarUser);

    // Hide the CSS button if no CSS configurable
    if (ModelApplication.configuration.css.length <= 0) {
        $(view.topBarCssBtn).hide();
    }

    // Hide the Global variables button if no configurable variables
    if (ModelApplication.configuration.vars.length <= 0) {
        $(view.topBarVarBtn).hide();
    }

    // Not append the system configurable button if not requested by PHP configuration file
    if (ModelApplication.configurable) {
        $(view.topBarRight).append(view.topBarConfigureBtn);
    }

    $(view.topBarRight).append(view.topBarLogoutBtn);

    // Set the logged user name
    $(view.topBarUser).html(ModelApplication.user.name);

    // DEFINE THE MODULE CONTAINER
    view.moduleContainer = $('<div class="row" id="moduleContainer"></div>');

    // APPEND ELEMENTS TO THE MAIN VIEW
    var _viewMain = $("#viewMain");
    $(_viewMain).append(view.topBar, view.moduleContainer);

    // CREATE THE TAB NAVIGATOR
    view.tabNavigator = new ComponentCustomTabNavigator(view.topBarMiddle, view.moduleContainer); // The tab navigator element

    // CREATE MAIN MENU
    view.componentMainMenu = new ComponentMainMenuClass($(_viewMain), view.tabNavigator, ModelApplication.configuration.menu);

    // ADD THE HOME VIEW TO THE MODULE CONTAINER
    view.home = new ViewHomeClass(view.moduleContainer);

    // SHOW MAIN MENU EVENT
    $(view.topBarMenuBtn).click(function () {
        view.componentMainMenu.open();
    });

    // DEFINE THE HOME BUTTON EVENT
    $(view.topBarHomeBtn).click(function () {
        view.tabNavigator.select("home");
    });

    // DEFINE THE CSS BUTTON EVENT
    $(view.topBarCssBtn).click(function () {
        view.showCssPopUp();
    });

    // DEFINE THE GLOBAL VARIABLES BUTTON EVENT
    $(view.topBarVarBtn).click(function () {
        view.showVarPopUp();
    });

    // LOGOUT
    $(view.topBarLogoutBtn).click(function () {
        UtilsHttp.goToUrl(GLOBAL_URL_MANAGER_LOGIN);
    });

    // CONFIGURATION WINDOW
    $(view.topBarConfigureBtn).click(function () {
        new ViewConfigurationPopUp();
    });

    // WINDOW RESIZE EVENT
    $(window).resize(function () {
        ManagerEvent.dispatch(ControlApplication, ModelApplication.EVENT_WINDOW_RESIZE);
    });

    ManagerEvent.addEventListener(ControlApplication, ModelApplication.EVENT_WINDOW_RESIZE, function () {
        view.resize();
    });

    // Dispatch the keyboard shortcuts for the selected module
    $(document).keydown(function (e) {
        // For CTRL + C
        if (e.ctrlKey && e.keyCode == 67) {
            ManagerEvent.dispatch(view.tabNavigator.modules[ModelApplication.selectedModuleName], ModelApplication.EVENT_KEYBOARD_COPY);
        }
        // For CTRL + V
        if (e.ctrlKey && e.keyCode == 86) {
            ManagerEvent.dispatch(view.tabNavigator.modules[ModelApplication.selectedModuleName], ModelApplication.EVENT_KEYBOARD_PASTE);
        }
        // For CTRL + A
        if (e.ctrlKey && e.keyCode == 65) {
            ManagerEvent.dispatch(view.tabNavigator.modules[ModelApplication.selectedModuleName], ModelApplication.EVENT_KEYBOARD_SELECT_ALL);
        }
        // For SUPR
        if (e.keyCode == 46) {
            ManagerEvent.dispatch(view.tabNavigator.modules[ModelApplication.selectedModuleName], ModelApplication.EVENT_KEYBOARD_DELETE);
        }
    });
}


/** Browser window resize event */
ViewApplicationClass.prototype.resize = function () {
    // Define this view
    var view = this;

    // Resize the middle top bar container element width
    $(view.topBarMiddle).width($(view.topBar).width() - ($(view.topBarLeft).width() + $(view.topBarRight).width()) - 20);

    // Resize the module container element width
    $(view.moduleContainer).width($("#viewMain").width());
};


/**
 * Show the waiting window
 */
ViewApplicationClass.prototype.wait = function () {
    if (ModelApplication.waitingProcessQuantity == 0) {
        ManagerCursor.setState("wait");
        ManagerPopUp.wait();
    }
    ModelApplication.waitingProcessQuantity++;
};


/**
 * Close the waiting window
 */
ViewApplicationClass.prototype.closeWait = function () {
    if (ModelApplication.waitingProcessQuantity > 0) {
        ModelApplication.waitingProcessQuantity--;
    }

    if (ModelApplication.waitingProcessQuantity == 0) {
        ManagerCursor.setState();
        ManagerPopUp.closeWait();
    }
};


/**
 * Show the CSS configuration popup
 */
ViewApplicationClass.prototype.showCssPopUp = function () {
    // Define this view
    var view = this;

    view.cssPopUp = new ViewCssPopUp();
};


/**
 * Show the global variables configuration popup
 */
ViewApplicationClass.prototype.showVarPopUp = function () {
    // Define this view
    var view = this;

    view.varPopUp = new ViewVarPopUp();
};