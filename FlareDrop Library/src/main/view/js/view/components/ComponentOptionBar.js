/**
 * Option bar component
 *
 * @param parentElement The parent element
 * @param values An array containing objects with "value" and "label" properties
 * @param onChangeAction The function called when selecting an element, returning the selected value on the first parameter
 *
 */
function ComponentOptionBar(parentElement, values, onChangeAction) {

    // Define this component
    var component = this;

    // Define the parent element
    component.parentElement = parentElement;

    // Define the container element
    component.container = $('<ul class="componentOptionBar unselectable"></ul>');

    // Define on change action
    component.onChangeAction = onChangeAction;

    // Define the selected index
    component.selectedIndex = 0;

    // Define the selected value
    component.selectedValue = "";

    // Create the different options
    $(values).each(function (k, v) {

        var option = $('<li class="unselectable" index="' + k + '" val="' + v.value + '"><p>' + v.label + '</p></li>');

        // Select the first one
        if (k == 0) {
            $(option).addClass("componentOptionBarSelected");
        }

        $(component.container).append(option);
    });

    // Append the component to the parent element
    $(component.parentElement).append(component.container);

    // Define the click event
    $(component.container).find("li").click(function () {

        if ($(this).attr("index") != component.selectedIndex) {
            component.selectIndex($(this).attr("index"));
        }
    });
}


/**
 * Select the index
 */
ComponentOptionBar.prototype.selectIndex = function (index) {

    // Define this component
    var component = this;

    // Modify the selected index
    component.selectedIndex = Number(index);

    // Refresh the view of the selected item
    $(component.container).find("li").removeClass("componentOptionBarSelected");

    $(component.container).find("li").each(function (k, v) {
        if ($(v).attr("index") == component.selectedIndex) {
            $(v).addClass("componentOptionBarSelected");
            component.selectedValue = $(v).attr("val");
        }
    });

    // Call the action
    if (component.onChangeAction !== undefined) {
        component.onChangeAction.apply(null, [component.selectedValue]);
    }
};


/**
 * Get the component's current selected index
 *
 * @returns index
 */
ComponentOptionBar.prototype.getSelectedIndex = function () {

    // Define this component
    var component = this;

    return component.selectedIndex;
};


/**
 * Get the component's current selected value
 *
 * @returns index
 */
ComponentOptionBar.prototype.getSelectedValue = function () {

    // Define this component
    var component = this;

    return component.selectedValue;
};