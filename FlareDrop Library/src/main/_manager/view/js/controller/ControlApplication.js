function ControlApplicationClass() {
    // Define this control
    var control = this;

    // Get the global application data
    control.configurationGet();
}


/**
 * Get the application global data
 */
ControlApplicationClass.prototype.configurationGet = function () {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        dataType: "json",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationGet",
        timeout: ModelApplication.ajaxTimeOut,
        success: function (data) {
            ModelApplication.configuration = data.configuration;
            ModelApplication.user = data.user;
            ModelApplication.disks = data.disks;
            ModelApplication.rootId = data.rootId;
            ModelApplication.payPalBusiness = data.payPalBusiness;
            ModelApplication.privilegeWriteId = data.privilegeWriteId;
            ModelApplication.privilegeReadId = data.privilegeReadId;
            ModelApplication.payPalSandboxEnabled = data.sandboxEnabled;
            ModelApplication.configurable = data.configurable;
            ManagerEvent.dispatch(control, ModelApplication.EVENT_GET_DATA_SUCCESS);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationGet();
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration menu
 *
 * @param objectType The configuration menu object type
 */
ControlApplicationClass.prototype.configurationMenuRemove = function (objectType) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationMenuRemove",
        data: {"objectType": objectType},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_MENU_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationMenuRemove(objectType);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration object
 *
 * @param objectType The configuration object type
 */
ControlApplicationClass.prototype.configurationObjectRemove = function (objectType) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationObjectRemove",
        data: {"objectType": objectType},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_OBJECT_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationObjectRemove(objectType);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration filter
 *
 * @param objectType The configuration object type
 */
ControlApplicationClass.prototype.configurationFilterRemove = function (objectType) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationFilterRemove",
        data: {"objectType": objectType},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_FILTER_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationFilterRemove(objectType);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration property
 *
 * @param propertiesConfigurationId The property configuration id
 */
ControlApplicationClass.prototype.configurationPropertyRemove = function (propertiesConfigurationId) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationPropertyRemove",
        data: {"propertiesConfigurationId": propertiesConfigurationId},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_PROPERTY_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationPropertyRemove(propertiesConfigurationId);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration list
 *
 * @param listConfigurationId The list configuration id
 */
ControlApplicationClass.prototype.configurationListRemove = function (listConfigurationId) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationListRemove",
        data: {"listConfigurationId": listConfigurationId},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_LIST_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationListRemove(listConfigurationId);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration css
 *
 * @param cssConfigurationId The CSS configuration id
 */
ControlApplicationClass.prototype.configurationCssRemove = function (cssConfigurationId) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationCssRemove",
        data: {"cssConfigurationId": cssConfigurationId},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_CSS_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationCssRemove(cssConfigurationId);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Remove a configuration global variable
 *
 * @param variable The global variable
 */
ControlApplicationClass.prototype.configurationVarRemove = function (variable) {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationVarRemove",
        data: {"variable": variable},
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            control.configurationGet();
            ManagerEvent.dispatch(control, ModelApplication.EVENT_VAR_CONFIGURATION_REMOVE);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.configurationVarRemove(variable);
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_CONFIGURATION_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Get the database files used space in bytes
 */
ControlApplicationClass.prototype.getFilesUsedSpace = function () {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        dataType: "json",
        data: {"type": "file"},
        url: GLOBAL_URL_WEB_SERVICE_BASE + "FileUsedSpaceGet",
        timeout: ModelApplication.ajaxTimeOut,
        success: function (data) {
            ModelApplication.dataBaseFilesUsedSpace = data;
            ManagerEvent.dispatch(control, ModelApplication.EVENT_GET_FILES_USED_SPACE_SUCCESS);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.getFilesUsedSpace();
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_FILES_SPACE_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};


/**
 * Get the database images used space in bytes
 */
ControlApplicationClass.prototype.getPicturesUsedSpace = function () {
    // Define this control
    var control = this;

    $.ajax({
        method: "POST",
        dataType: "json",
        data: {"type": "picture"},
        url: GLOBAL_URL_WEB_SERVICE_BASE + "FileUsedSpaceGet",
        timeout: ModelApplication.ajaxTimeOut,
        success: function (data) {
            ModelApplication.dataBasePicturesUsedSpace = data;
            ManagerEvent.dispatch(control, ModelApplication.EVENT_GET_PICTURES_USED_SPACE_SUCCESS);
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                control.getPicturesUsedSpace();
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("GET_PICTURES_SPACE_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};