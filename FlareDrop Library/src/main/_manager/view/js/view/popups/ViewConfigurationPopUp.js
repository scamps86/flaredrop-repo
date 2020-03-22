/**
 * Configuration PopUp
 *
 */
function ViewConfigurationPopUp() {

    // Declare this view
    var view = this;

    // Create the popup
    view.w = ManagerPopUp.window(ModelApplication.literals.get("CONFIGURATION_POPUP_TITLE", "ManagerApp"), "", {
        width: 900,
        maxHeight: 600
    });

    $(view.w).attr("id", "configurationPopUpWindow");

    // Create the forms
    view.frmMenu = $('<form class="row" id="configurationMenu" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationMenuSet" + '"></form>');
    view.frmObjects = $('<form class="row" id="configurationObjects" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationObjectSet" + '"></form>');
    view.frmFilters = $('<form class="row" id="configurationFilters" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationFilterSet" + '"></form>');
    view.frmProperties = $('<form class="row" id="configurationProperties" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationPropertySet" + '"></form>');
    view.frmLists = $('<form class="row" id="configurationLists" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationListSet" + '"></form>');
    view.frmCss = $('<form class="row" id="configurationCss" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationCssSet" + '"></form>');
    view.frmVar = $('<form class="row" id="configurationVar" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationVarSet" + '"></form>');
    view.frmTesting = $('<form class="row" id="configurationTesting" serviceUrl="' + GLOBAL_URL_WEB_SERVICE_BASE + "SystemTestingRun" + '"></form>');

    $(view.frmMenu).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_OBJECTTYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_LITERALKEY", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_ICON", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmObjects).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_OBJECTTYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_BUNDLE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDERS_LINK", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDERS_SHOW", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_OPTIONS_SHOW", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_LEVELS", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_FILES_ENABLED", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FILES_ENABLED", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_PICTURES_ENABLED", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURES_ENABLED", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURE_DIMENSIONS", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURE_QUALITY", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmFilters).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_OBJECTTYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_DISK", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_DISK_DEFAULT", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_TEXT_PROPERTIES", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_PERIOD", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmProperties).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_ID", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_OBJECTTYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_PROPERTY", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_DEFAULT_VALUE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_LITERALKEY", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_TYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_LOCALIZED", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_BASE64ENCODE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_VALIDATE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_VALIDATE_CONDITION", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_VALIDATE_ERROR_LOCALE_KEY", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmLists).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_ID", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_OBJECTTYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_PROPERTY", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_LITERALKEY", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_FORMAT_TYPE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_WIDTH", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmCss).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_ID", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_NAME", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_SELECTOR", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmVar).html('<p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_VAR_VARIABLE", "ManagerApp") + '</p><p class="fontBold">' + ModelApplication.literals.get("CONFIGURATION_POPUP_VAR_NAME", "ManagerApp") + '</p><div class="frmContents"></div>');
    $(view.frmTesting).html('<input type="submit" value="' + ModelApplication.literals.get("CONFIGURATION_POPUP_TESTING_RUN", "ManagerApp") + '" /><div class="row"></div>');

    $(view.frmObjects).hide();
    $(view.frmFilters).hide();
    $(view.frmProperties).hide();
    $(view.frmLists).hide();
    $(view.frmCss).hide();
    $(view.frmVar).hide();
    $(view.frmTesting).hide();

    view.refresh();

    // Add the bar component on the popup top
    new ComponentOptionBar(view.w, [
        {value: "menu", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_MENU", "ManagerApp")},
        {value: "objects", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_OBJECTS", "ManagerApp")},
        {value: "filters", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_FILTERS", "ManagerApp")},
        {
            value: "properties",
            label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_PROPERTIES", "ManagerApp")
        },
        {value: "lists", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_LISTS", "ManagerApp")},
        {value: "css", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_CSS", "ManagerApp")},
        {value: "var", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_VAR", "ManagerApp")},
        {value: "testing", label: ModelApplication.literals.get("CONFIGURATION_POPUP_OPTION_TESTING", "ManagerApp")}
    ], function (val) {
        $(view.w).find("form").hide();
        switch (val) {
            case "menu":
                $(view.frmMenu).show();
                break;
            case "objects":
                $(view.frmObjects).show();
                break;
            case "filters":
                $(view.frmFilters).show();
                break;
            case "properties":
                $(view.frmProperties).show();
                break;
            case "lists":
                $(view.frmLists).show();
                break;
            case "css":
                $(view.frmCss).show();
                break;
            case "var":
                $(view.frmVar).show();
                break;
            case "testing":
                $(view.frmTesting).show();
                break;
        }
    });

    // Add the forms to the window
    $(view.w).append(view.frmMenu, view.frmObjects, view.frmFilters, view.frmProperties, view.frmLists, view.frmCss, view.frmVar, view.frmTesting);

    // Add the forms to the form manager
    ManagerForm.add(view.frmMenu, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmObjects, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmFilters, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmProperties, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmLists, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmCss, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmVar, function () {
        view.configurationSetSuccessHandler();
    }, function () {
        view.configurationSetErrorHandler();
    });
    ManagerForm.add(view.frmTesting, function () {
        view.configurationTestErrorHandler("TEST CRASH");//Empty string means that there is an error
    }, function (e) {
        view.configurationTestCompleteHandler(e.target.responseText);
    });

    // Add the event listeners
    ManagerEvent.addEventListener(ControlApplication, ModelApplication.EVENT_GET_DATA_SUCCESS, function () {
        view.refresh();
    });
    $(view.frmTesting).find("input[type=submit]").click(function () {
        ViewApplication.wait();
    });
}


/**
 * Refresh the forms
 */
ViewConfigurationPopUp.prototype.refresh = function () {
    // Define this view
    var view = this;

    // REFRESH THE MENU FORM
    var html = $('<div class="row"></div>');

    $(ModelApplication.configuration.menu).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" objectType="' + v.objectType + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationMenuRemove($(this).attr("objectType"));
        });

        $(row).html('<p class="defined" title="' + v.objectType + '">' + v.objectType + '</p><p class="defined" title="' + v.literalKey + '">' + v.literalKey + '</p><p class="defined" title="' + v.iconClassName + '">' + v.iconClassName + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="15" name="objectType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_OBJECTTYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="literalKey" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_LITERALKEY", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="iconClassName" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_MENU_ICON", "ManagerApp") + '">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmMenu).find("div.frmContents").html(html);

    // REFRESH THE OBJECTS FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.objects).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" objectType="' + v.objectType + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationObjectRemove($(this).attr("objectType"));
        });

        $(row).html('<p class="defined" title="' + v.objectType + '">' + v.objectType + '</p><p class="defined" title="' + v.bundle + '">' + v.bundle + '</p><p class="defined" title="' + v.foldersLink + '">' + v.foldersLink + '</p><p class="defined" title="' + v.foldersShow + '">' + v.foldersShow + '</p><p class="defined" title="' + v.folderOptionsShow + '">' + v.folderOptionsShow + '</p><p class="defined" title="' + v.folderLevels + '">' + v.folderLevels + '</p><p class="defined" title="' + v.folderFilesEnabled + '">' + v.folderFilesEnabled + '</p><p class="defined" title="' + v.filesEnabled + '">' + v.filesEnabled + '</p><p class="defined" title="' + v.folderPicturesEnabled + '">' + v.folderPicturesEnabled + '</p><p class="defined" title="' + v.picturesEnabled + '">' + v.picturesEnabled + '</p><p class="defined" title="' + v.pictureDimensions + '">' + v.pictureDimensions + '</p><p class="defined" title="' + v.pictureQuality + '">' + v.pictureQuality + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="15" name="objectType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_OBJECTTYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="bundle" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_BUNDLE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="foldersLink" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDERS_LINK", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="foldersShow" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDERS_SHOW", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="folderOptionsShow" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_OPTIONS_SHOW", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="3" name="folderLevels" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_LEVELS", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="folderFilesEnabled" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_FILES_ENABLED", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="filesEnabled" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FILES_ENABLED", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="folderPicturesEnabled" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_FOLDER_PICTURES_ENABLED", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="picturesEnabled" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURES_ENABLED", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="255" name="pictureDimensions" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURE_DIMENSIONS", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="3" name="pictureQuality" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_PICTURE_QUALITY", "ManagerApp") + '">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmObjects).find("div.frmContents").html(html);

    // REFRESH THE FILTER FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.filters).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" objectType="' + v.objectType + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationFilterRemove($(this).attr("objectType"));
        });

        $(row).html('<p class="defined" title="' + v.objectType + '">' + v.objectType + '</p><p class="defined" title="' + v.showDisk + '">' + v.showDisk + '</p><p class="defined" title="' + v.diskDefault + '">' + v.diskDefault + '</p><p class="defined" title="' + v.showTextProperties + '">' + v.showTextProperties + '</p><p class="defined" title="' + v.showPeriod + '">' + v.showPeriod + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="15" name="objectType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_OBJECTS_OBJECTTYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="showDisk" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_DISK", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="2" name="diskDefault" validate="numberNatural" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_DISK_DEFAULT", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="255" name="showTextProperties" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_TEXT_PROPERTIES", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="showPeriod" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILTERS_SHOW_PERIOD", "ManagerApp") + '">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmFilters).find("div.frmContents").html(html);

    // REFRESH THE PROPERTIES FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.properties).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" propertiesConfigurationId="' + v.propertiesConfigurationId + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationPropertyRemove($(this).attr("propertiesConfigurationId"));
        });

        $(row).html('<p class="defined" title="' + v.propertiesConfigurationId + '">' + v.propertiesConfigurationId + '</p><p class="defined" title="' + v.objectType + '">' + v.objectType + '</p><p class="defined" title="' + v.property + '">' + v.property + '</p><p class="defined" title="' + v.defaultValue + '">' + v.defaultValue + '</p><p class="defined" title="' + v.literalKey + '">' + v.literalKey + '</p><p class="defined" title="' + v.type + '">' + v.type + '<p class="defined" title="' + v.localized + '">' + v.localized + '</p><p class="defined" title="' + v.base64Encode + '">' + v.base64Encode + '</p><p class="defined" title="' + v.validate + '">' + v.validate + '</p><p class="defined" title="' + v.validateCondition + '">' + v.validateCondition + '<p class="defined" title="' + v.validateErrorLiteralKey + '">' + v.validateErrorLiteralKey + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="20" name="propertiesConfigurationId" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_ID", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="objectType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_OBJECTTYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="property" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_PROPERTY", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="defaultValue" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_DEFAULT_VALUE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="literalKey" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_LITERALKEY", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="type" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_TYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="localized" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_LOCALIZED", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="1" name="base64Encode" validate="numberNatural;fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_PROPERTIES_BASE64ENCODE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="20" name="validate">');
    $(html).append('<input type="text" maxlength="3" name="validateCondition">');
    $(html).append('<input type="text" maxlength="45" name="validateErrorLiteralKey">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmProperties).find("div.frmContents").html(html);

    // REFRESH THE LIST FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.list).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" listConfigurationId="' + v.listConfigurationId + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationListRemove($(this).attr("listConfigurationId"));
        });

        $(row).html('<p class="defined" title="' + v.listConfigurationId + '">' + v.listConfigurationId + '</p><p class="defined" title="' + v.objectType + '">' + v.objectType + '</p><p class="defined" title="' + v.property + '">' + v.property + '</p><p class="defined" title="' + v.literalKey + '">' + v.literalKey + '</p><p class="defined" title="' + v.formatType + '">' + v.formatType + '</p><p class="defined" title="' + v.width + '">' + v.width + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="20" name="listConfigurationId" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_ID", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="objectType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_OBJECTTYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="property" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_PROPERTY", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="literalKey" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_LITERALKEY", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="15" name="formatType" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_FORMAT_TYPE", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="3" name="width" validate="numberNatural" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_LISTS_WIDTH", "ManagerApp") + '">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmLists).find("div.frmContents").html(html);

    // REFRESH THE CSS FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.css).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" cssConfigurationId="' + v.cssConfigurationId + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationCssRemove($(this).attr("cssConfigurationId"));
        });

        $(row).html('<p class="defined" title="' + v.cssConfigurationId + '">' + v.cssConfigurationId + '</p><p class="defined" title="' + v.name + '">' + v.name + '</p><p class="defined" title="' + v.selector + '">' + v.selector + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="15" name="cssConfigurationId" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_ID", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="45" name="name" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_NAME", "ManagerApp") + '">');
    $(html).append('<input type="text" maxlength="255" name="selector" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_CSS_SELECTOR", "ManagerApp") + '">');
    $(html).append('<input type="hidden" name="styles" value="" >');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmCss).find("div.frmContents").html(html);

    // REFRESH THE GLOBAL VARIABLES FORM
    html = $('<div class="row"></div>');

    $(ModelApplication.configuration.vars).each(function (k, v) {
        var row = $('<div class="row"></div>');
        var rm = $('<p class="defined remove" variable="' + v.variable + '">' + ModelApplication.literals.get("CONFIGURATION_POPUP_REMOVE", "ManagerApp") + "</p>");

        $(rm).click(function () {
            ControlApplication.configurationVarRemove($(this).attr("variable"));
        });

        $(row).html('<p class="defined" title="' + v.variable + '">' + v.variable + '</p><p class="defined" title="' + v.name + '">' + v.name + "</p>");
        $(row).append(rm);
        $(html).append(row);
    });

    $(html).append('<input type="text" maxlength="45" name="variable" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_VAR_VARIABLE", "ManagerApp") + '">');
    $(html).append('<input type="hidden" name="value" value="" >');
    $(html).append('<input type="text" maxlength="45" name="name" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("CONFIGURATION_POPUP_FILL", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '" placeholder="' + ModelApplication.literals.get("CONFIGURATION_POPUP_VAR_NAME", "ManagerApp") + '">');
    $(html).append('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" >');

    $(view.frmVar).find("div.frmContents").html(html);
};


/**
 * Configuration set error handler
 */
ViewConfigurationPopUp.prototype.configurationSetErrorHandler = function () {
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("SET_CONFIGURATION_ERROR", "ManagerApp"), [
        {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
    ], {className: "error"});
};


/**
 * Configuration set success handler
 */
ViewConfigurationPopUp.prototype.configurationSetSuccessHandler = function () {
    ControlApplication.configurationGet();
};


/**
 * Testing error handler
 *
 * @param errorMessage The error message
 */
ViewConfigurationPopUp.prototype.configurationTestErrorHandler = function (errorMessage) {
    // Define this view
    var view = this;

    // Close wait
    ViewApplication.closeWait();

    // Show error popup
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("CONFIGURATION_POPUP_TESTING_ERROR", "ManagerApp"), [
        {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
    ], {className: "error"});

    // Fill the testing results
    $(view.frmTesting).find("div").html(errorMessage);
};


/**
 * Testing success handler
 *
 * @param message The error message
 */
ViewConfigurationPopUp.prototype.configurationTestCompleteHandler = function (message) {
    // Define this view
    var view = this;

    // Close wait
    ViewApplication.closeWait();

    if (message.split(":")[0] == "TESTING OK") {

        // Show success popup
        ManagerPopUp.dialog(ModelApplication.literals.get("SUCCESS", "ManagerApp"), ModelApplication.literals.get("CONFIGURATION_POPUP_TESTING_SUCCESS", "ManagerApp"), [
            {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
        ], {className: "success"});

        // Empty the previous testing results
        $(view.frmTesting).find("div").html(message);
    }
    else {
        view.configurationTestErrorHandler(message);
    }
};



