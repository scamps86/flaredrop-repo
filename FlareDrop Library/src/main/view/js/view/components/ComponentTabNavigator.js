/**
 * Component that creates different tabs to navigate in.
 *
 * The component is an UL list and the class name is: <b>componentTabNavigator</b> and each tab have the class <b>componentTabNavigatorTab</b> and a tab-index attribute. Each tab label
 * have the class <b>componentTabNavigatorLabel</b> and each tab content have the class <b>componentTabNavigatorContents</b> but each one are not visible.
 *
 * The selected tab duplicates its own contents to another container at the end of the component's list. Its class name is <b>componentTabNavigatorSelectedContainer</b>.
 *
 * The selected tab have the class <b>componentTabNavigatorTabSelected</b>
 *
 * @param parentElement The HTML element where this component will be placed (when creating this component by Javascript)
 * @param phpComponentElement The component's element created as the PHP ComponentTabNavigator.
 */
function ComponentTabNavigator(parentElement, phpComponentElement) {

    // Define this component
    var component = this;

    // Define the current added tab index
    component._tabIndex = 0;

    // The selected tab index
    component._selectedIndex = -1;

    // Define the selected container
    component.selectedContainer = $('<li class="componentTabNavigatorSelectedContainer"></li>');

    // Define the container
    if (phpComponentElement !== undefined) {
        // Get the parent
        component.parent = $(phpComponentElement).parent();

        // Get the container through the PHP component
        component.container = phpComponentElement;

        // Assign the tabs index
        $(component.container).find(".componentTabNavigatorTab").each(function (k, v) {
            $(v).attr("tab-index", component._tabIndex);
            component._tabIndex++;
        });

        // Auto select the first tab only if there are tabs defined
        if (component._tabIndex > 0) {
            component.selectTab(0);
        }
    }
    else {
        // Set the parent
        component.parent = parentElement;

        // Create the component container
        $(component.parent).append('<ul class="componentTabNavigator"></ul>');
    }

    // Add the selected container at the end of the component's list
    $(component.container).append(component.selectedContainer);

    // Refresh the component
    component._refresh();
}


/**
 * Add a tab to the component
 *
 * @param label The tab label
 * @param contents The tab contents as a plain text or HTML / element
 * @param className The optional class name for the tab
 * @param autoSelect Boolean than tells if the tab we are adding will be automatically selected. False by default
 */
ComponentTabNavigator.prototype.addTab = function (label, contents, className, autoSelect) {
    // Define this component
    var component = this,
        li = $('<li class="componentTabNavigatorTab unselectable" tab-index="' + component._tabIndex + '"></li>'),
        h2 = $('<h2 class="componentTabNavigatorLabel">' + label + '</h2>'),
        div = $('<div class="componentTabNavigatorContents"></div>');

    // Increase the tab index
    component._tabIndex++;

    // Append the contents
    $(div).append(contents);

    // Add a custom class name to the tab
    if (className !== undefined) {
        $(li).addClass(className);
    }

    // Do the appends
    $(li).append(h2, div);
    $(component.container).append(li);

    // Refresh the component
    component._refresh();

    // Select the first /current tab
    autoSelect === undefined ? component.selectTab(0) : component.selectTab(component._tabIndex - 1);

    // Add the selected container at the end of the component's list
    $(component.selectedContainer).remove();
    $(component.container).append(component.selectedContainer);
};


/**
 * Select an specified tab by its index
 *
 * @param tabIndex The tab index starting by 0
 */
ComponentTabNavigator.prototype.selectTab = function (tabIndex) {
    // Define this component
    var component = this;

    var tabs = $(component.container).find(".componentTabNavigatorTab"),
        tab = component.getTabElementByIndex(tabIndex),
        selectedTab = component.getTabElementByIndex(component._selectedIndex);

    // Unselect all tabs
    $(tabs).removeClass("componentTabNavigatorTabSelected");

    // Test if the index range exists and then select the specified tab
    if (tab) {
        $(tab).addClass("componentTabNavigatorTabSelected");

        // Move the current selected contents to its own container
        $(selectedTab).append($(component.selectedContainer).find(".componentTabNavigatorContents"));

        // Set the tab contents to the selected contents container
        $(component.selectedContainer).html($(tab).find(".componentTabNavigatorContents"));

        // Set the selected index
        component._selectedIndex = tabIndex;
    }
};


/**
 * Get the selected tab index
 *
 * @returns The current selected index
 */
ComponentTabNavigator.prototype.getSelectedIndex = function () {
    // Define this component
    var component = this;

    return component._selectedIndex;
};


/**
 * Get the tab element by its own index
 *
 * @param tabIndex The tab index
 *
 * @returns The tab element or null if not exists
 */
ComponentTabNavigator.prototype.getTabElementByIndex = function (tabIndex) {
    // Define this component
    var component = this;

    var tabs = $(component.container).find(".componentTabNavigatorTab");

    if (tabs.length >= tabIndex && tabIndex >= 0) {
        return tabs[tabIndex];
    }
    else {
        return null;
    }
};


/**
 * Refresh the component's tabs
 */
ComponentTabNavigator.prototype._refresh = function () {
    // Define this component
    var component = this,
        tabs = $(component.container).find(".componentTabNavigatorTab");

    // Remove previous click event listeners
    $(tabs).unbind("click");

    // Add the event listener for each tab
    $(tabs).click(function () {
        component.selectTab($(this).attr("tab-index"));
    });
};