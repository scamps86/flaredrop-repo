/**
 * Export PopUp
 *
 */
function ViewExportPopUp(moduleComponent) {
    // Declare this view
    var view = this;

    // Set the moduleComponent
    view.moduleComponent = moduleComponent;

    // Set the csv columns to be sent
    view.csvColumns = [];

    // Define the events listener
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_SUCCESS, view._loadObjectColumnsSuccessHandler.bind(this));
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_ERROR, view._loadObjectColumnsErrorHandler.bind(this));

    // Do the call to get the columns to export
    view._loadObjectColumns();
}


/**
 * Load the object columns through an ajax call
 */
ViewExportPopUp.prototype._loadObjectColumns = function () {
    // Define this view
    var view = this;

    // Do the call
    view.moduleComponent.controller.objectsColumnsGet();
};


/**
 * The success handler for the get columns
 */
ViewExportPopUp.prototype._loadObjectColumnsSuccessHandler = function () {
    // Declare this view
    var view = this;

    // Remove the event listeners
    ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_SUCCESS);
    ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_ERROR);

    // Validate if the received data is empty
    if (view.moduleComponent.modeler.objectsColumnsGet.length <= 0) {
        view._loadObjectColumnsErrorHandler();
        return;
    }

    // Create the popup
    view.w = ManagerPopUp.window(ModelApplication.literals.get("OBJECT_EXPORT_POPUP_TITLE", "ManagerApp"), "", {
        width: 300,
        maxHeight: 600
    });

    // Set the popup id
    $(view.w).attr("id", "exportPopUpWindow");

    // Read the columns data
    $(view.moduleComponent.modeler.objectsColumnsGet).each(function (k, v) {
        var row = $('<div class="row exportPopUpRow"><p>' + v + ':</p></div>');
        new ComponentSwitch(row, true, function (checked) {
            if (checked) {
                view.csvColumns.push(v);
            }
            else {
                view.csvColumns.splice(view.csvColumns.indexOf(v), 1);
            }
        });
        $(view.w).append(row);
    });

    // Add the submit button
    var submitBtn = $('<input id="exportSubmitBtn" type="submit" value="' + ModelApplication.literals.get("EXPORT", "ManagerApp") + '" />');
    $(view.w).append(submitBtn);

    // Add the click event handler to the submit button
    $(submitBtn).click(function () {
        view.moduleComponent.controller.objectsCsvGet(view.csvColumns);
        ManagerPopUp.closeAll();
    });
};

/**
 * The error handler for the get columns
 */
ViewExportPopUp.prototype._loadObjectColumnsErrorHandler = function () {
    // Define this view
    var view = this;

    // Remove the event listeners
    ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_SUCCESS);
    ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_ERROR);

    // Show dialog
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_EXPORT_ERROR_MESSAGE", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};