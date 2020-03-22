/**
 * Create a datagrid component
 *
 * @param parentElement The parent element
 * @param primaryKey The primary key property name that stores the item ID on each item from the data provider
 * @param folder The folder id property name to allow viewing what items are on the current level of the selected folder (not mandatory)
 * @param properties The properties to apply. This is an array containing an object for each property with "property", "label", "type" and "percentWidth" like: [{property : "name", label : "Nom", type : "text" percentWidth : "25"}, {...}, ...]
 *
 * The allowed data types are: "text", "check", "files", "pictures"
 *
 * @param dataProvider The data provider array containing each item object like: [{id : "20", name : "Sergi", age : "27"}, {...}, ...]
 * @param options An object containing all datagrid options: "draggable" false by default, "dragRevertTime" 200 by default, "dragCursorAt" {top: 14, left : -15} by default, "dragHelperContent" "Drag me!" by default
 * @param events An object containing the event actions: "onSelect", "onUnselect", "onDragStart", "onSortClick[property name]", "onDblClick", "onUnselectAll", "onSelectAll"
 *
 */
function ComponentDataGrid(parentElement, primaryKey, folder, properties, dataProvider, options, events) {

    // Define this component
    var component = this;

    // Define the parent element
    component.parentElement = parentElement;

    // Set the primary key property name
    component.primaryKey = primaryKey;

    // Set the folder id property name
    component.folder = folder;

    // Get the property info
    component.properties = properties;

    // Get the data provider
    component.dataProvider = dataProvider;

    // Set the datagrid options
    options = options === undefined ? {} : options;
    component.draggable = options.draggable === undefined ? false : options.draggable;
    component.dragRevertTime = options.dragRevertTime === undefined ? 200 : options.dragRevertTime;
    component.dragCursorAt = options.dragCursorAt === undefined ? {
        top: 14,
        left: -15
    } : options.dragCursorAt;
    component.dragHelperContent = options.dragHelperContent === undefined ? "Drag me!" : options.dragHelperContent;

    // Initialize the events object
    events = events === undefined ? {} : events;

    // Set on select action
    component.onSelect = events.onSelect;

    // Set on unselect action
    component.onUnselect = events.onUnselect;

    // Set on drag start action
    component.onDragStart = events.onDragStart;

    // Set on sort click action
    component.onSortClick = events.onSortClick;

    // Set on double click action
    component.onDblClick = events.onDblClick;

    // Set on unselect all action
    component.onUnselectAll = events.onUnselectAll;

    // Set on select all action
    component.onSelectAll = events.onSelectAll;

    // Define selected items array
    component.selectedItems = [];

    // Create the datagrid container
    component.container = $('<div class="componentDataGrid"></div>');

    // Create the divided box component
    component.dividedBox = null;

    // Generate the table
    component.update(component.dataProvider);

    // Do the appends
    $(component.container).append(component.headerContainer, component.container);
    $(component.parentElement).append(component.container);
}


/**
 * Update the datagrid data
 *
 * @param dataProvider The data provider array containing each item object like: [{id : "20", name : "Sergi", age : "27"}, {...}, ...]
 * @param selectedFolderId The current external selected folder id (not mandatory)
 *
 */
ComponentDataGrid.prototype.update = function (dataProvider, selectedFolderId) {

    // Define this component
    var component = this;

    // Update the data provider
    component.dataProvider = dataProvider;

    // Clear the grid data cells
    $(component.container).empty();

    // Create the divided box for the table
    component.dividedBox = new ComponentDividedBox(component.container, 5);

    // Generate the new data columns
    $(component.properties).each(function (k, p) {

        // Create the column
        var col = $('<ul class="componentDataGridCol componentDataGridCol' + k + '"></ul>');

        // Add the header to the column
        var h = $('<li class="componentDataGridRow componentDataGridRowHeader"><p>' + p.label + "</p></li>");
        $(col).append(h);

        // Add the click event to the header
        $(h).click(function () {
            if (component.onSortClick !== undefined) {
                component.onSortClick.apply(null, [p.property]);
            }
        });

        // Create the data rows
        $(component.dataProvider).each(function (l, d) {
            var pairClassName = l % 2 == 0 ? "componentDataGridRowPair" : "";
            var r = $('<li class="componentDataGridRow componentDataGridRow' + l + " " + pairClassName + '" itemId="' + d[component.primaryKey] + '"></li>');

            // Check if the property exists on the data provider item
            if (d[p.property] !== undefined && p.type !== undefined) {
                if (p.type == "text") {
                    $(r).html("<p>" + UtilsString.htmlSpecialChars(d[p.property]) + "</p>");
                }
                else if (p.type == "check") {
                    if (d[p.property] == 1) {
                        $(r).html('<p class="checkEnabled"></p>');
                    }
                    else {
                        $(r).html('<p class="checkDisabled"></p>');
                    }
                }
                else if (p.type == "files" || p.type == "pictures") {
                    $(r).html('<p>' + (d[p.property] == "" ? 0 : d[p.property].split(";").length) + '</p>');
                }
            }

            // Add the row to the column
            $(col).append(r);

            // Row click event
            $(r).click(function () {
                component.toogleRow($(this).attr("itemId"));
            });

            // Row double click
            $(r).dblclick(function () {
                component.unselectAllItems();
                component.selectItem($(this).attr("itemId"));

                if (component.onDblClick !== undefined) {
                    component.onDblClick.apply();
                }
            });

            // Set the rows draggable
            if (component.draggable) {
                $(r).draggable({
                    cursor: "move",
                    cursorAt: component.dragCursorAt,
                    revert: "invalid",
                    revertDuration: component.dragRevertTime,
                    helper: function () {
                        return '<div class="componentDataGridDragHelper">' + component.dragHelperContent + '</div>';
                    },
                    distance: 15,
                    containment: "window",
                    appendTo: "body",
                    start: function (event) {

                        // Auto select on drag starting
                        component.selectItem($(event.currentTarget).attr("itemId"));

                        // Call the action if defined
                        if (component.onDragStart !== undefined) {

                            component.onDragStart.apply();
                        }
                    }
                });
            }
        });

        // Add the column to the table
        component.dividedBox.add(col, p.percentWidth);
    });

    // Update the selected items
    component._updateSelectedItems();
};


/**
 * Toogle an item
 *
 * @param id The item id to toogle
 */
ComponentDataGrid.prototype.toogleRow = function (id) {

    // Define this component
    var component = this;

    $(component.container).find("li.componentDataGridRow").each(function (k, v) {
        if ($(v).attr("itemId") == id) {
            if ($(v).hasClass("componentDataGridRowSelected")) {
                component.unselectItem(id);
            }
            else {
                component.selectItem(id);
            }
            return false;
        }
    });
};


/**
 * Select an item
 *
 * @param id The item id to select
 */
ComponentDataGrid.prototype.selectItem = function (id) {

    // Define this component
    var component = this, rows = $(component.container).find("li.componentDataGridRow");

    $(rows).each(function (k, v) {
        if ($(v).attr("itemId") == id) {
            $(v).addClass("componentDataGridRowSelected");
        }
    });

    // Update the selected items
    component._updateSelectedItems();

    // Dispatch the select event
    if (component.onSelect !== undefined) {

        component.onSelect.apply(null, [component.getItem(id)]);
    }
};


/**
 * Unselect an item
 *
 * @param id The item id to unselect
 */
ComponentDataGrid.prototype.unselectItem = function (id) {

    // Define this component
    var component = this, rows = $(component.container).find("li.componentDataGridRow.componentDataGridRowSelected");

    $(rows).each(function (k, v) {
        if ($(v).attr("itemId") == id) {
            $(v).removeClass("componentDataGridRowSelected");

            // Update the selected items
            component._updateSelectedItems();

            // Dispatch the unselect event
            if (component.onUnselect !== undefined) {
                component.onUnselect.apply(null, [component.getItem(id)]);
            }
        }
    });
};


/**
 * Unselect all datagrid items
 */
ComponentDataGrid.prototype.unselectAllItems = function () {
    // Define this component
    var component = this, rows = $(component.container).find("li.componentDataGridRow.componentDataGridRowSelected");

    if (rows.length > 0) {
        $(rows).removeClass("componentDataGridRowSelected");

        // Update the selected items
        component._updateSelectedItems();

        // Dispatch the unselect all event
        if (component.onUnselectAll !== undefined) {
            component.onUnselectAll.apply();
        }
    }
};


/**
 * Select all datagrid items
 */
ComponentDataGrid.prototype.selectAllItems = function () {
    // Define this component
    var component = this, rows = $(component.container).find("li.componentDataGridRow").not(".componentDataGridRowSelected");

    if (rows.length > 0) {
        $(rows).addClass("componentDataGridRowSelected");

        // Update the selected items
        component._updateSelectedItems();

        // Dispatch the unselect all event
        if (component.onSelectAll !== undefined) {
            component.onSelectAll.apply();
        }
    }
};


/**
 * Get an item object. If not exists, it returns a null element
 *
 * @param id The item id
 *
 * @returns Object
 */
ComponentDataGrid.prototype.getItem = function (id) {

    // Define this component
    var component = this;

    var item = null;

    $(component.dataProvider).each(function (k, i) {
        if (i[component.primaryKey] == id) {

            item = i;
        }
    });

    return item;
};


/**
 * Get the selected items as an array
 *
 * @returns Array
 */
ComponentDataGrid.prototype.getSelectedItems = function () {

    // Define this component
    var component = this;

    return component.selectedItems;
};


/**
 * Update the current selected items array
 */
ComponentDataGrid.prototype._updateSelectedItems = function () {

    // Define this component
    var component = this;

    component.selectedItems = [];

    $(component.container).find("ul.componentDataGridCol0 li.componentDataGridRow.componentDataGridRowSelected").each(function (k, v) {

        var item = component.getItem($(v).attr("itemId"));

        if (item != null) {
            component.selectedItems.push(item);
        }
    });
};