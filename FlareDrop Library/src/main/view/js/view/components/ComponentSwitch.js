/**
 * Component that allows to boolean switch. The component's class name is "componentSwitch" and also the "componentSwitchOpened" class name if the switch is opened.
 *
 * @param parentElement The HTML element where this component will be placed
 * @param opened Mark if the switch is opened when staring. False by default
 * @param toggleAction The action called when the switch is toggled. It returns a boolean telling if the switch is checked or not
 */
function ComponentSwitch(parentElement, opened, toggleAction) {

    // Define this component
    var component = this;

    // Get the parent element
    component.parent = parentElement;

    // Get the toogle action
    component.toggleAction = toggleAction;

    // Define the element checked or not
    component.checked = false;

    // Create the component's container
    component.container = $("<div></div>");
    $(component.container).addClass("componentSwitch unselectable transitionFast");

    // Create the inner button
    component.innerBtn = $("<div></div>");
    $(component.innerBtn).addClass("componentSwitchInnerBtn unselectable transitionFast");

    // Do the appends
    $(component.container).append(component.innerBtn);
    $(component.parent).append(component.container);

    // Auto check if param is defined
    if (opened == true) {
        component.toogle();
    }

    // Declare the component's click event listener
    $(component.container).click(function () {
        component.toogle();
    });
}


/**
 * Check the switch
 */
ComponentSwitch.prototype.check = function () {
    // Define this component
    var component = this;

    // Check the element
    component.checked = true;

    // Update the checked class
    if (component.checked) {
        $(component.container).addClass("componentSwitchOpened");
    }
    else {
        $(component.container).removeClass("componentSwitchOpened");
    }
};


/**
 * Uncheck the switch
 */
ComponentSwitch.prototype.uncheck = function () {
    // Define this component
    var component = this;

    // Check the element
    component.checked = false;

    // Update the checked class
    if (component.checked) {
        $(component.container).addClass("componentSwitchOpened");
    }
    else {
        $(component.container).removeClass("componentSwitchOpened");
    }
};


/**
 * Toogle the switch
 */
ComponentSwitch.prototype.toogle = function () {
    // Define this component
    var component = this;

    // Check or uncheck the element
    component.checked = !component.checked;

    // Update the checked class
    if (component.checked) {
        $(component.container).addClass("componentSwitchOpened");
    }
    else {
        $(component.container).removeClass("componentSwitchOpened");
    }

    // Apply the toogle action
    if (component.toggleAction !== undefined) {

        component.toggleAction.apply(null, [component.checked]);
    }
};


/**
 * Get if the switch is opened or not
 *
 * @returns boolean
 */
ComponentSwitch.prototype.isOpened = function () {

    // Define this component
    var component = this;

    return component.checked;
};