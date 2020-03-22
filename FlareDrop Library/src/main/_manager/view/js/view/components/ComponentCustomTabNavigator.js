/**
 * Create the custom tab navigator component
 *
 * @param tabContainerElement The tab container element previously created on the main view
 * @param moduleContainerElement The module container element previously created on the main view
 *
 */
function ComponentCustomTabNavigator(tabContainerElement, moduleContainerElement) {
    // Define this component
    var component = this;

    // DEFAULT VARIABLES
    component.selected = ""; // The module name

    // Get and create the required elements
    component.container = tabContainerElement;
    component.tabContainer = $('<ul id="topBarTabs"></ul>');
    component.moduleContainer = moduleContainerElement;

    // Object containing all module components. Callable by it's module name
    component.modules = {};

    // Append the container element to the parent element
    $(component.container).append(component.tabContainer);
}


/**
 * Add a tab to the tab navigator bar
 *
 * @param label The label for the tab
 * @param moduleName The module name
 */
ComponentCustomTabNavigator.prototype.add = function (label, moduleName) {
    // Define this component
    var component = this;

    if (!component.isTabAdded(moduleName)) {
        // CREATE THE REQUIRED ELEMENTS:
        // li: The main container that has the other tab elements
        // leftDiv: The left container that has the p element (the label)
        // rightDiv: The right container that has the close button
        var tab = $("<li></li>");
        var closeBtn = $('<div class="closeTabBtn skinIcon"></div>');
        var p = $("<p>" + label + "</p>");

        // Fill the tab data
        $(tab).attr("moduleName", moduleName);

        // Do the appends
        $(tab).append(closeBtn, p);

        $(component.tabContainer).append(tab);

        // Add on tab click event
        $(tab).click(function () {
            component.select($(this).attr("moduleName"));
        });

        // Add on tab button close click
        $(closeBtn).click(function () {
            component.remove($(tab).attr("moduleName"));
        });

        // Create the module and add it to the module container element
        if (component.modules[moduleName] === undefined) {
            component.modules[moduleName] = new ComponentModule(moduleName, component.moduleContainer);
        }
    }
    else {
        // If already exists, select it
        component.select(moduleName);
    }

    // Make the sortable tabs
    $(component.tabContainer).sortable({
        axis: "x",
        containment: "parent",
        revert: 200,
        opacity: 0.3,
        tolerance: "pointer"
    });

    // Select the added tab when the module is created
    ManagerEvent.addEventListener(component.modules[moduleName], component.modules[moduleName].modeler.EVENT_MODULE_CREATE_SUCCESS, function () {

        component.select(moduleName);
    });
};


/**
 * Remove the specified tab
 *
 * @param moduleName
 */
ComponentCustomTabNavigator.prototype.remove = function (moduleName) {
    // Define this component
    var component = this;

    $(component.tabContainer).children("li").each(function (k, tab) {

        if ($(tab).attr("moduleName") == moduleName) {

            // Remove the tab
            $(tab).remove();

            // Remove the module
            component.modules[moduleName].remove(function () {
                $(component.modules).removeProp(moduleName);
            });

            // Set the home if the removed tab is the selected tab
            if (component.selected == moduleName) {
                component.select("home");
            }
        }
    });
};


/**
 * Select the specified tab. If the specified tab does not exist, it will minimize all tabs
 *
 * @param moduleName The name of the module. "home" is to show the home view
 */
ComponentCustomTabNavigator.prototype.select = function (moduleName) {
    // Define this component
    var component = this;

    // Get all tabs
    var tabs = $(component.tabContainer).find("li");

    // Set all tabs as unselected
    $(tabs).removeClass("selected");

    $(tabs).each(function (k, tab) {

        // Verify that the tab is not the placeholder created by jQuery UI on dragging it
        if ($(tab).attr("moduleName") !== undefined) {
            // Hide all modules
            component.modules[$(tab).attr("moduleName")].hide();

            // Show the selected module
            if ($(tab).attr("moduleName") == moduleName) {

                // Show the module
                if (component.modules[moduleName] !== undefined) {

                    $(ViewApplication.home.homeContainer).hide();
                    component.modules[moduleName].show();
                }

                // Set the selected tab as selected
                $(tab).addClass("selected");
            }
        }
    });

    // Show the home if module name is "home"
    if (moduleName == "home") {
        ViewApplication.home.update();
        $(ViewApplication.home.homeContainer).show();
    }

    component.selected = moduleName;
    ModelApplication.selectedModuleName = moduleName;
};


/**
 * It returns a boolean telling if the current module is added on the tap bar or not
 *
 * @param moduleName The name of the module
 *
 * @returns {Boolean}
 */
ComponentCustomTabNavigator.prototype.isTabAdded = function (moduleName) {
    // Define this component
    var component = this;
    var isAdded = false;

    $(component.tabContainer).find("li").each(function (k, tab) {
        if ($(tab).attr("moduleName") == moduleName) {
            isAdded = true;
        }
    });

    return isAdded;
};