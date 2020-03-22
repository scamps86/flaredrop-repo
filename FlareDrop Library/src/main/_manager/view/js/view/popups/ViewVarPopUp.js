/**
 * Global variables PopUp
 */
function ViewVarPopUp() {

    // Declare this view
    var view = this;

    // Define selected variable id
    view.selectedVariable = "";

    // Define value to save
    view.valueToSave = "";

    // Define the container
    view.container = $('<ul id="varPopUpContainer" class="row"></ul>');

    // Generate the contents
    $(ModelApplication.configuration.vars).each(function (k, v) {
        var option = $('<li class="row"><p class="row">' + v.name + '</p><textarea class="row" placeholder="' + ModelApplication.literals.get("VAR_CONFIGURATION_VALUE", "ManagerApp") + '">' + v.value + '</textarea></li>'),
            submitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '" variable="' + v.variable + '" />');
        $(option).append(submitBtn);
        $(view.container).append(option);
    });

    // Get the inner elements
    view.textareas = $(view.container).find("li > textarea");
    view.ps = $(view.container).find("li > p");
    view.submits = $(view.container).find("li > input[type=submit]");

    // Create the popup
    view.w = ManagerPopUp.window(ModelApplication.literals.get("VAR_CONFIGURATION_TITLE", "ManagerApp"), view.container, {
        width: 400,
        maxHeight: 600
    });

    // Define the events
    $(view.ps).click(function () {
        $(this).next().slideToggle(300);
        $(this).next().next().slideToggle(300);
    });
    $(view.submits).click(function () {
        view.selectedVariable = $(this).attr("variable");
        view.valueToSave = $(this).prev().val();
        view.save();
    });

    // Unselect all
    $(view.textareas).hide();
    $(view.submits).hide();

    // Select the first one
    $(view.ps).first().trigger("click");
}


/**
 * Save the changes
 */
ViewVarPopUp.prototype.save = function () {
    // Declare this view
    var view = this, data = {};

    // Set application as waiting
    ViewApplication.wait();

    // Generate the data to be sent
    $(ModelApplication.configuration.vars).each(function (k, v) {
        if (v.variable == view.selectedVariable) {
            v.value = view.valueToSave;
            data = v;
        }
    });

    console.log(data);

    // Do the ajax request
    $.ajax({
        method: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemConfigurationVarSet",
        data: data,
        timeout: ModelApplication.ajaxTimeOut,
        success: function () {
            ManagerPopUp.dialog(ModelApplication.literals.get("SUCCESS", "ManagerApp"), ModelApplication.literals.get("VAR_CONFIGURATION_SAVE_SUCCESS", "ManagerApp"), [
                {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
            ], {className: "success"});
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                view.save();
            }
            else {
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("VAR_CONFIGURATION_SAVE_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        },
        complete: function () {
            ViewApplication.closeWait();
        }
    })
};