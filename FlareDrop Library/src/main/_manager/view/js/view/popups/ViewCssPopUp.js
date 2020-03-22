/**
 * CSS PopUp
 */
function ViewCssPopUp() {

    // Declare this view
    var view = this;

    // Define selected CSS id
    view.selectedCssId = -1;

    // Define styles to save
    view.stylesToSave = "";

    // Define the container
    view.container = $('<ul id="cssPopUpContainer" class="row"></ul>');

    // Generate the contents
    $(ModelApplication.configuration.css).each(function (k, v) {
        var option = $('<li class="row"><p class="row">' + v.name + '</p><textarea class="row" placeholder="' + ModelApplication.literals.get("CSS_CONFIGURATION_ENTER_CODE", "ManagerApp") + '">' + v.styles + '</textarea></li>'),
            submitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" cssId="' + v.cssConfigurationId + '" />');
        $(option).append(submitBtn);
        $(view.container).append(option);
    });

    // Get the inner elements
    view.textareas = $(view.container).find("li > textarea");
    view.ps = $(view.container).find("li > p");
    view.submits = $(view.container).find("li > input[type=submit]");

    // Create the popup
    view.w = ManagerPopUp.window(ModelApplication.literals.get("CSS_CONFIGURATION_TITLE", "ManagerApp"), view.container, {
        width: 400,
        maxHeight: 600
    });

    // Define the events
    $(view.ps).click(function () {
        $(this).next().slideToggle(300);
        $(this).next().next().slideToggle(300);
    });
    $(view.submits).click(function () {
        view.selectedCssId = $(this).attr("cssId");
        view.stylesToSave = $(this).prev().val();
        view._showSureDialog();
    });

    // Unselect all
    $(view.textareas).hide();
    $(view.submits).hide();

    // Select the first one
    $(view.ps).first().trigger("click");
}


/**
 * Show sure dialog
 */
ViewCssPopUp.prototype._showSureDialog = function () {
    // Declare this view
    var view = this;

    // Show dialog
    ManagerPopUp.dialog(ModelApplication.literals.get("WARNING", "ManagerApp"), ModelApplication.literals.get("CSS_CONFIGURATION_SURE", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp"),
            action: function () {
                view.save();
            }
        },
        {
            label: ModelApplication.literals.get("CANCEL", "ManagerApp")
        }
    ], {
        className: "warning"
    });
};


/**
 * Save the changes
 */
ViewCssPopUp.prototype.save = function () {
    // Declare this view
    var view = this, data = {};

    // Set application as waiting
    ViewApplication.wait();

    // Generate the data to be sent
    $(ModelApplication.configuration.css).each(function (k, v) {
        if (v.cssConfigurationId == view.selectedCssId) {
            v.styles = view.stylesToSave;
            data = v;
        }
    });

    // Do the ajax request
    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationCssSet",
        data: data,
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            ManagerPopUp.dialog(ModelApplication.literals.get("SUCCESS", "ManagerApp"), ModelApplication.literals.get("CSS_CONFIGURATION_SAVE_SUCCESS", "ManagerApp"), [
                {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
            ], {className: "success"});
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                view.save();
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("CSS_CONFIGURATION_SAVE_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        },
        complete: function () {
            ViewApplication.closeWait();
        }
    })
};