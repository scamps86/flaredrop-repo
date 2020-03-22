/**
 * Create the main menu element
 */
function ComponentMainMenuClass(parentElement, tabNavigatorElement, menuData) {

    // Define component
    var component = this;

    // Define elements
    component.parentElement = parentElement;
    component.container = $('<ul id="mainMenu"></ul>');
    component.tabNavigator = tabNavigatorElement;

    // READ THE APPLICATION CONFIGURATION AND GENERATE THE CONTENTS
    $(menuData).each(function (k, s) {

        // Create the option elements
        var li = $('<li class="' + s.iconClassName + '"></li>');
        var label = $("<p>" + ModelApplication.literals.get(s.literalKey, ModelApplication.bundle) + "</p>");

        // Attach the module params to the label properties
        $(li).attr("objectType", s.objectType);

        // Define the label onclick action
        $(li).click(function () {
            component.optionSelect(this);
        });

        // Do the appends
        $(li).append(label);
        $(component.container).append(li);
    });

    // Hide the menu by default
    $(component.container).hide();

    // EVENT TO CLOSE THE MENU
    $(document).click(function (element) {
        if ($(element.target).attr("id") != "topBarMenuBtn") {

            component.close();
        }
    });

    // Do the component's container append to the parent
    $(component.parentElement).append(component.container);
}


/**
 * Select a menu option
 *
 * @param item the menu P item (sLabel)
 */
ComponentMainMenuClass.prototype.optionSelect = function (item) {

    // Define component
    var component = this;

    component.tabNavigator.add($(item).find("p").html(), $(item).attr("objectType"));
    component.close();
};


/**
 * Show or hide the main menu
 */
ComponentMainMenuClass.prototype.toggle = function () {

    // Define component
    var component = this;

    $(component.container).slideToggle(200);
};


/**
 * Close the main menu
 */
ComponentMainMenuClass.prototype.close = function () {

    // Define component
    var component = this;

    $(component.container).slideUp(200);
};


/**
 * Open the main menu
 */
ComponentMainMenuClass.prototype.open = function () {

    // Define component
    var component = this;

    $(component.container).slideDown(200);
};