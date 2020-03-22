/**
 * The module general component
 *
 * @param moduleName The module name
 * @param containerElement The module's container element
 */
function ComponentModule(moduleName, containerElement) {

    // Define this component
    var component = this;

    // The parent element of this module
    component.containerElement = containerElement;

    // Define the module MODEL
    component.modeler = new ModelModule(moduleName, component);

    // Define the module CONTROLLER
    component.controller = new ControlModule(component);

    // Define the module VIEWER
    component.viewer = null;
}


/**
 * Show the module to the main window
 */
ComponentModule.prototype.show = function () {

    // Define this component
    var component = this;

    // Set module as visible
    component.modeler.isSelected = true;

    // Show this component to the main window
    $(component.viewer.module).show();
};


/**
 * Hide the module from the main window
 */
ComponentModule.prototype.hide = function () {

    // Define this component
    var component = this;

    // Set module as not visible
    component.modeler.isSelected = false;

    // Hide this component from the main window
    $(component.viewer.module).hide();
};


/**
 * Remove the module from the application modules container. Please consider that it's not possible auto delete the class. To delete it you must delete manually outside this class
 *
 * @param successAction The success action
 */
ComponentModule.prototype.remove = function (successAction) {

    // Define this component
    var component = this;

    // Remove this component from the modules container
    ManagerEvent.removeEventListener(component);
    $(component.viewer.module).remove();

    // Do the success callback
    if (successAction !== undefined) {
        successAction.apply();
    }
};


/**
 * Refresh all of this module data
 */
ComponentModule.prototype.refresh = function () {

    // Define this component
    var component = this;

    // Call the module refresh method
    component.controller.refresh();

};