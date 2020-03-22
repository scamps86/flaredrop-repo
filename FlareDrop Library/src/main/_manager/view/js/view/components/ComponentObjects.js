function ComponentObjects(moduleComponent) {

    // Define this component
    var component = this;

    // Get the module component
    component.moduleComponent = moduleComponent;

    // Create the component's container
    component.container = $('<div class="componentObjects"></div>');

    // Create the top object options
    component.objectOptionsContainer = $('<div class="row bar objectOptionsContainer"></div>');

    component.objectOptionAdd = $('<div class="optionBtn skinIcon addObjectBtn objectOption unselectable"></div>');
    component.objectOptionRemove = $('<div class="optionBtn skinIcon remObjectBtn objectOption unselectable"></div>');
    component.objectOptionEdit = $('<div class="optionBtn skinIcon editObjectBtn objectOption unselectable"></div>');
    component.objectOptionAttach = $('<div class="optionBtn skinIcon attachObjectBtn objectOption unselectable"></div>');
    component.objectOptionCopy = $('<div class="optionBtn skinIcon copyObjectBtn objectOption unselectable"></div>');
    component.objectOptionPaste = $('<div class="optionBtn skinIcon pasteObjectBtn objectOption unselectable"></div>');
    component.objectOptionSelectAll = $('<div class="optionBtn skinIcon selectAllObjectBtn objectOption optionBtnEnabled unselectable"></div>');
    component.objectOptionExport = $('<div class="optionBtn skinIcon expObjectBtn objectOption unselectable"></div>');

    // Define the tooltips for the options
    $(component.objectOptionAdd).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_NEW", "ManagerApp"));
    $(component.objectOptionRemove).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_REMOVE", "ManagerApp"));
    $(component.objectOptionEdit).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_EDIT", "ManagerApp"));
    $(component.objectOptionAttach).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_ATTACH", "ManagerApp"));
    $(component.objectOptionCopy).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_COPY", "ManagerApp"));
    $(component.objectOptionPaste).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_PASTE", "ManagerApp"));
    $(component.objectOptionSelectAll).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_SELECT_ALL", "ManagerApp"));
    $(component.objectOptionExport).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_EXPORT", "ManagerApp"));

    // Apply the configuration
    if (component.moduleComponent.modeler.configuration.objects.filesEnabled != 1 && component.moduleComponent.modeler.configuration.objects.picturesEnabled != 1) {
        $(component.objectOptionAttach).hide();
    }

    // Hide import and export buttons only for the users
    if (component.moduleComponent.modeler.name == "user") {
        $(component.objectOptionCopy).hide();
        $(component.objectOptionPaste).hide();
        $(component.objectOptionExport).hide();
    }

    // Add click events to the dataGrid buttons
    $(component.objectOptionAdd).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showAddObjectPopUp();
        }
    });

    $(component.objectOptionEdit).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showEditObjectPopUp();
        }
    });

    $(component.objectOptionAttach).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showAttatchPopUp();
        }
    });

    $(component.objectOptionRemove).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showRemoveObjectPopUp();
        }
    });

    $(component.objectOptionCopy).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._objectsCopy();
        }
    });

    $(component.objectOptionPaste).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._objectsPaste();
        }
    });

    $(component.objectOptionSelectAll).click(function () {
        component._toggleSelectAll();
    });

    $(component.objectOptionExport).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showExportPopUp();
        }
    });

    // Append the top object buttons to the container
    $(component.objectOptionsContainer).append(component.objectOptionAdd, component.objectOptionRemove, component.objectOptionCopy, component.objectOptionPaste, component.objectOptionSelectAll, component.objectOptionEdit, component.objectOptionAttach, component.objectOptionExport);

    // If disk input is enabled on the configuration, create the component and its things
    if (component.moduleComponent.modeler.configuration.filters.showDisk == "1") {
        // Create the filter component to choose the disk, and set the selected disk item on the beginning
        var disks = [];

        $(ModelApplication.disks).each(function (k, v) {
            if (v["diskId"] == component.moduleComponent.modeler.selectedDisk) {
                disks.push({
                    value: v["diskId"],
                    label: v["name"]
                });
            }
        });

        $(ModelApplication.disks).each(function (k, v) {
            if (v["diskId"] != component.moduleComponent.modeler.selectedDisk) {
                disks.push({
                    value: v["diskId"],
                    label: v["name"]
                });
            }
        });

        component.objectFilterDisk = new ComponentOptionBar(component.objectOptionsContainer, disks, function (disk) {
            component.moduleComponent.modeler.currentPage = 0;
            component.moduleComponent.controller.setDisk(disk);
        });
    }

    // If text search is enabled, create the component and its needly things
    if (component.moduleComponent.modeler.configuration.filters.showTextProperties != "") {
        // Create the filter component for text search
        component.objectFilterText = $('<input class="dataGridFilterText" type="text" placeholder="' + ModelApplication.literals.get("FILTER_TEXT_SEARCH", "ManagerApp") + '">');

        // Define the change event
        $(component.objectFilterText).keyup(function () {

            // Fill the current input filter text to the model of this module
            component.moduleComponent.modeler.filterTextSearch = $(this).val();

            // Call the controller to get the list
            component.moduleComponent.modeler.currentPage = 0;
            component.moduleComponent.controller.objectsGet();
        });

        $(component.objectOptionsContainer).append(component.objectFilterText);
    }

    // Create the filter component for the date pick
    if (component.moduleComponent.modeler.configuration.filters.showPeriod == "1") {
        component.objectFilterPeriod = new ComponentPeriodChooser(component.moduleComponent, component.objectOptionsContainer, "dataGridFilterPeriod");
    }

    // Create the pagination options
    component.paginationContainer = $('<p class="paginationContainer"></p>').hide();
    component.paginationPrev = $('<span class="paginationPrev skinIcon"></span>');
    component.paginationNext = $('<span class="paginationNext skinIcon"></span>');
    component.paginationIndicator = $('<span class="paginationIndicator"></span>');

    // Do the pagination appends
    $(component.paginationContainer).append(component.paginationPrev, component.paginationIndicator, component.paginationNext);
    $(component.objectOptionsContainer).append(component.paginationContainer);

    // Set the event listeners
    $(component.paginationPrev).click(function () {
        component.goToPreviousPage();
    });

    $(component.paginationNext).click(function () {
        component.goToNextPage();
    });

    // Create the datagrid container
    component.datagridContainer = $('<div class="row datagridContainer unselectable"></div>');

    // Create the datagrid
    component.datagrid = new ComponentDataGrid(component.datagridContainer, component.moduleComponent.modeler.primaryKey, "folderId", component._getFormattedProperties(), component.moduleComponent.modeler.objectsList.list, {
        dragHelperContent: "<p>" + ModelApplication.literals.get("OBJECT_DRAG", "ManagerApp") + "</p>",
        draggable: component.moduleComponent.modeler.configuration.objects.foldersShow == 1
    }, {
        onSelect: function () {

            component.moduleComponent.modeler.selectedObjects = component.datagrid.getSelectedItems();
            component.topItemOptionsRefresh();
        },
        onUnselect: function () {

            component.moduleComponent.modeler.selectedObjects = component.datagrid.getSelectedItems();
            component.topItemOptionsRefresh();
        },
        onSortClick: function (property) {

            var sort = component.moduleComponent.modeler.sortObjectsBy;
            sort = [property, sort[1] == "ASC" ? "DESC" : "ASC"];

            component.moduleComponent.modeler.sortObjectsBy = sort;
            component.moduleComponent.controller.objectsGet();
        },
        onDblClick: function () {
            $(component.objectOptionEdit).trigger("click");
        },
        onUnselectAll: function () {
            component.moduleComponent.modeler.selectedObjects = component.datagrid.getSelectedItems();
            component.topItemOptionsRefresh();
        },
        onSelectAll: function () {
            component.moduleComponent.modeler.selectedObjects = component.datagrid.getSelectedItems();
            component.topItemOptionsRefresh();
        }
    });

    // Append to the container
    $(component.container).append(component.objectOptionsContainer, component.datagridContainer);


    // EVENT LISTENERS
    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECT_SET_SUCCESS, function () {
        component._objectSetSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECT_SET_ERROR, function () {
        component._objectSetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_GET_SUCCESS, function () {
        component._objectsGetSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_GET_ERROR, function () {
        component._objectsGetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_REMOVE_SUCCESS, function () {
        component._objectRemoveSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_REMOVE_ERROR, function () {
        component._objectRemoveErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECT_GET_SUCCESS, function () {
        component._objectGetSuccesHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECT_GET_ERROR, function () {
        component._objectGetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_MOVE_SUCCESS, function () {
        component._objectMoveSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_MOVE_ERROR, function () {
        component._objectMoveErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_LINK_SUCCESS, function () {
        component._objectLinkSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_LINK_ERROR, function () {
        component._objectLinkErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_UNLINK_SUCCESS, function () {
        component._objectUnlinkSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_UNLINK_ERROR, function () {
        component._objectUnlinkErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_DUPLICATE_SUCCESS, function () {
        component._objectsDuplicateSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_OBJECTS_DUPLICATE_ERROR, function () {
        component._objectsDuplicateErrorHandler();
    });

    // Keyboard shortcuts
    if (component.moduleComponent.modeler.name != "user") {
        ManagerEvent.addEventListener(component.moduleComponent, ModelApplication.EVENT_KEYBOARD_COPY, function () {
            $(component.objectOptionCopy).trigger("click");
        });

        ManagerEvent.addEventListener(component.moduleComponent, ModelApplication.EVENT_KEYBOARD_PASTE, function () {
            $(component.objectOptionPaste).trigger("click");
        });
    }

    ManagerEvent.addEventListener(component.moduleComponent, ModelApplication.EVENT_KEYBOARD_DELETE, function () {
        $(component.objectOptionRemove).trigger("click");
    });

    ManagerEvent.addEventListener(component.moduleComponent, ModelApplication.EVENT_KEYBOARD_SELECT_ALL, function () {
        $(component.objectOptionSelectAll).trigger("click");
    });
}


/**
 * Refresh top object option buttons to be enabled / disabled
 */
ComponentObjects.prototype.topItemOptionsRefresh = function () {

    // Define this component
    var component = this;

    // Disable all buttons
    $(component.objectOptionAdd).removeClass("optionBtnEnabled");
    $(component.objectOptionEdit).removeClass("optionBtnEnabled");
    $(component.objectOptionAttach).removeClass("optionBtnEnabled");
    $(component.objectOptionRemove).removeClass("optionBtnEnabled");
    $(component.objectOptionCopy).removeClass("optionBtnEnabled");
    $(component.objectOptionPaste).removeClass("optionBtnEnabled");

    // Enable export button
    $(component.objectOptionExport).addClass("optionBtnEnabled");

    // Count the selected items
    var itemsCount = component.moduleComponent.modeler.selectedObjects.length;

    // Verify add and paste buttons
    if (component.moduleComponent.modeler.selectedFolder != null) {
        $(component.objectOptionAdd).addClass("optionBtnEnabled");

        if (component.moduleComponent.modeler.copiedItems.length > 0) {
            $(component.objectOptionPaste).addClass("optionBtnEnabled");
        }
    }

    // Verify other buttons
    if (itemsCount >= 1) {
        $(component.objectOptionCopy).addClass("optionBtnEnabled");
        if (itemsCount == 1) {
            $(component.objectOptionEdit).addClass("optionBtnEnabled");

            if (component.moduleComponent.modeler.name != "user") {
                $(component.objectOptionAttach).addClass("optionBtnEnabled");
            }
        }

        var allow = true;

        $(component.moduleComponent.modeler.selectedObjects).each(function (k, s) {
            if (s.privilegeId != ModelApplication.privilegeWriteId) {
                allow = false;
                return false;
            }
        });

        if (allow) {
            $(component.objectOptionRemove).addClass("optionBtnEnabled");
        }
    }
    else {
        // Set select all as default
        $(component.objectOptionSelectAll).removeClass("unselectAllObjectBtn");
        $(component.objectOptionSelectAll).addClass("selectAllObjectBtn");
    }

    // Update the paginator
    if (component.moduleComponent.modeler.objectsList.totalPages > 1) {
        $(component.paginationContainer).show();
    }
    else {
        $(component.paginationContainer).hide();
    }

    if (component.moduleComponent.modeler.currentPage == 0) {
        $(component.paginationPrev).hide();
    }
    else {
        $(component.paginationPrev).show();
    }

    if (component.moduleComponent.modeler.currentPage + 1 == component.moduleComponent.modeler.objectsList.totalPages) {
        $(component.paginationNext).hide();
    }
    else {
        $(component.paginationNext).show();
    }

    $(component.paginationIndicator).html((component.moduleComponent.modeler.currentPage + 1) + " / " + component.moduleComponent.modeler.objectsList.totalPages);
};


/**
 * Show object add PopUp
 */
ComponentObjects.prototype._showAddObjectPopUp = function () {

    // Define this component
    var component = this;

    new ViewObjectEditPopUp(component.moduleComponent);
};


/**
 * Show object edit PopUp
 */
ComponentObjects.prototype._showEditObjectPopUp = function () {

    // Define this component
    var component = this;

    // Define the action to apply when the object is received
    component.moduleComponent.attachOrEdit = "EDIT";

    // Get the selected object Id
    var objectId = component.moduleComponent.modeler.selectedObjects[0][component.moduleComponent.modeler.primaryKey];

    // Call the controller to get the object
    component.moduleComponent.controller.objectGet(objectId);
};


/**
 * Show attatch PopUp
 */
ComponentObjects.prototype._showAttatchPopUp = function () {
    // Define this component
    var component = this;

    // Not allow adding images / files for the users
    if (component.moduleComponent.modeler.object == "user") {
        ManagerPopUp.dialog(ModelApplication.literals.get("ALERT", "ManagerApp"), ModelApplication.literals.get("ATTACH_NOT_ALLOWED_USERS", "ManagerApp"), [
            {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
        ], {className: "error"});
        return;
    }

    // Define the action to apply when the object is received
    component.moduleComponent.attachOrEdit = "ATTACH";

    // Get the selected object Id
    var objectId = component.moduleComponent.modeler.selectedObjects[0][component.moduleComponent.modeler.primaryKey];

    // Call the controller to get the object
    component.moduleComponent.controller.objectGet(objectId);
};


/**
 * Show object remove question dialog
 */
ComponentObjects.prototype._showRemoveObjectPopUp = function () {
    // Define this component
    var component = this;

    // Show the remove question popup
    ManagerPopUp.dialog(ModelApplication.literals.get("ALERT", "ManagerApp"), ModelApplication.literals.get("OBJECT_REMOVE_QUESTION", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("OBJECT_UNLINK", "ManagerApp"),
            action: function () {
                // Call the controller to do the operation
                if (component._validateSelectedObjectsToProcess()) {
                    component.moduleComponent.controller.objectsUnlink();
                }
                else {
                    // If we cannot unlink the selected elements, show error message
                    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_UNLINK_CANNOT_MESSAGE", "ManagerApp"), [{
                        label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
                    }], {className: "error"});
                }
            }
        },
        {
            label: ModelApplication.literals.get("OBJECT_REMOVE", "ManagerApp"),
            action: function () {
                // Call the controller to do the operation
                component.moduleComponent.controller.objectsRemove();
            }
        }
    ], {
        className: "warning"
    });
};


/**
 * Show the object/s move / link popup
 */
ComponentObjects.prototype.showMoveObjectPopUp = function () {
    // Define this component
    var component = this;

    // Show question popup
    if (component._validateSelectedObjectsToProcess()) {
        // If foldersLink is activated, ask if we want to move or to link. If not, move it directly.
        if (component.moduleComponent.modeler.configuration.objects.foldersLink == 1) {
            ManagerPopUp.dialog(ModelApplication.literals.get('ALERT', 'ManagerApp'), ModelApplication.literals.get("OBJECT_DRAG_QUESTION", "ManagerApp"), [
                {
                    label: ModelApplication.literals.get("OBJECT_MOVE", "ManagerApp"),
                    action: function () {
                        component.moduleComponent.controller.objectsMove();
                    }
                }, {
                    label: ModelApplication.literals.get("OBJECT_LINK", "ManagerApp"), action: function () {
                        // Call the move method on the controller
                        component.moduleComponent.controller.objectsLink();
                    }
                }], {className: 'warning'});
        }
        else {
            component.moduleComponent.controller.objectsMove();
        }
    }
    else {
        // If we cannot move / link the selected elements, show error message
        ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_MOVE_LINK_CANNOT_MESSAGE", "ManagerApp"), [{
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }], {className: "error"});
    }
};


/**
 * Show the object edit window when a object is getted from the database
 */
ComponentObjects.prototype._objectGetSuccesHandler = function () {
    // Define the component
    var component = this;

    if (component.moduleComponent.attachOrEdit == "EDIT") {
        // Show the edit popUp with all object data filled
        new ViewObjectEditPopUp(component.moduleComponent, component.moduleComponent.modeler.objectGet);
    }

    if (component.moduleComponent.attachOrEdit == "ATTACH") {
        // Show the attach popUp with all object data filled
        new ViewAttachPopUp(component.moduleComponent, component.moduleComponent.modeler.objectGet, "object");
    }

    // Remove the action to apply if it's not an attach request
    if (component.moduleComponent.attachOrEdit != "ATTACH_REQUEST") {
        component.moduleComponent.attachOrEdit = null;
    }
};


/**
 * Show error when trying to get an object to be edited and it fails
 */
ComponentObjects.prototype._objectGetErrorHandler = function () {
    // Define the component
    var component = this;

    // Show the error notification
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_GET_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });

    // Remove the action to apply if it's not an attach request
    if (component.moduleComponent.attachOrEdit != "ATTACH_REQUEST") {
        component.moduleComponent.attachOrEdit = null;
    }
};


/**
 * On object remove success
 */
ComponentObjects.prototype._objectRemoveSuccessHandler = function () {

    // Define this component
    var component = this;

    // If the current user is affected, logout
    if (component.moduleComponent.modeler.name == "user") {
        var ids = UtilsConversion.jsonToObject(component.moduleComponent.modeler.ajaxRemove.ids);
        $(ids).each(function (k, v) {
            if (v == ModelApplication.user.userId) {
                UtilsHttp.goToUrl(GLOBAL_URL_MANAGER_LOGIN);
                return false;
            }
        })
    }

    // Refresh the list
    component.moduleComponent.controller.objectsGet();
};


/**
 * On object remove error
 */
ComponentObjects.prototype._objectRemoveErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_REMOVE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * On objects list get success
 */
ComponentObjects.prototype._objectsGetSuccessHandler = function () {

    // Define this component
    var component = this;

    // Get the selected folder id
    var folderId = component.moduleComponent.modeler.selectedFolder != null ? component.moduleComponent.modeler.selectedFolder.folderId : undefined;

    // Update the current page
    component.moduleComponent.modeler.currentPage = component.moduleComponent.modeler.objectsList.currentPage;

    // Update the datagrid dataprovider
    component.datagrid.update(component.moduleComponent.modeler.objectsList.list, folderId);

    // Reset the selected objects
    component.moduleComponent.modeler.selectedObjects = [];

    // Refresh the top options
    component.topItemOptionsRefresh();
};


/**
 * On objects list get error
 */
ComponentObjects.prototype._objectsGetErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_GET_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * Get the formatted properties array to be used on the datagrid
 *
 * @returns Array
 */
ComponentObjects.prototype._getFormattedProperties = function () {

    // Define this component
    var component = this;

    var result = [];

    $(component.moduleComponent.modeler.configuration.list).each(function (k, p) {

        result.push({
            property: p.property,
            label: ModelApplication.literals.get(p.literalKey, component.moduleComponent.modeler.configuration.objects.bundle),
            type: p.formatType,
            percentWidth: p.width
        });
    });

    return result;
};


/**
 * On object set success
 */
ComponentObjects.prototype._objectSetSuccessHandler = function () {

    // Define this component
    var component = this;

    // If the current user is affected, logout
    if (component.moduleComponent.modeler.name == "user") {
        if (component.moduleComponent.modeler.objectGet.name == ModelApplication.user.name) {
            UtilsHttp.goToUrl(GLOBAL_URL_MANAGER_LOGIN);
            return;
        }
    }

    ManagerPopUp.closeAll();
    component.moduleComponent.controller.objectsGet();
};


/**
 * On object set error
 */
ComponentObjects.prototype._objectSetErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_SET_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * On object move success
 */
ComponentObjects.prototype._objectMoveSuccessHandler = function () {

    // Define this component
    var component = this;

    // Select the dropped folder
    component.moduleComponent.viewer.folders.tree.selectNode(component.moduleComponent.modeler.droppedFolderId);

    // Set the dropped folder id as null
    component.moduleComponent.modeler.droppedFolderId = null;
};

/**
 * On object move error
 */
ComponentObjects.prototype._objectMoveErrorHandler = function () {

    // Define this component
    var component = this;

    // Set the dropped folder id as null
    component.moduleComponent.modeler.droppedFolderId = null;

    // Show error message
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_MOVE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {
        component.moduleComponent.viewer.folders.reloadFolders();
    });
};


/**
 * On object link success
 */
ComponentObjects.prototype._objectLinkSuccessHandler = function () {

    // Define this component
    var component = this;

    // Select the linked folder
    component.moduleComponent.viewer.folders.tree.selectNode(component.moduleComponent.modeler.droppedFolderId);

    // Set the dropped folder id as null
    component.moduleComponent.modeler.droppedFolderId = null;
};


/**
 * On object link error
 */
ComponentObjects.prototype._objectLinkErrorHandler = function () {

    // Define this component
    var component = this;

    // Set the dropped folder id as null
    component.moduleComponent.modeler.droppedFolderId = null;

    // Show error message
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_LINK_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {
        component.moduleComponent.viewer.folders.reloadFolders();
    });
};


/**
 * On object unlink success
 */
ComponentObjects.prototype._objectUnlinkSuccessHandler = function () {
    // Define this component
    var component = this;

    // If the current user is affected, logout
    if (component.moduleComponent.modeler.name == "user") {
        var ids = UtilsConversion.jsonToObject(component.moduleComponent.modeler.ajaxUnlink.ids);
        $(ids).each(function (k, v) {
            if (v == ModelApplication.user.userId) {
                UtilsHttp.goToUrl(GLOBAL_URL_MANAGER_LOGIN);
                return false;
            }
        })
    }

    // Refresh the list
    component.moduleComponent.controller.objectsGet();
};


/**
 * On object unlink error
 */
ComponentObjects.prototype._objectUnlinkErrorHandler = function () {

    // Define this component
    var component = this;

    // Show error message
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_UNLINK_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {
        component.reloadFolders();
    });
};


/**
 * On objects duplicate success
 */
ComponentObjects.prototype._objectsDuplicateSuccessHandler = function () {

    // Define this component
    var component = this;


    // Refresh the list
    component.moduleComponent.controller.objectsGet();
};


/**
 * On objects duplicate error
 */
ComponentObjects.prototype._objectsDuplicateErrorHandler = function () {

    // Define this component
    var component = this;


    // Show error message
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("OBJECT_PASTE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });

    // Refresh the list
    component.moduleComponent.controller.objectsGet();
};


/**
 * Copy the selected objects and save it to the module's model
 */
ComponentObjects.prototype._objectsCopy = function () {

    // Define this component
    var component = this, copiedItems = [];

    // Validate if the current module is selected
    if (component.moduleComponent.modeler.isSelected) {

        // Get the selected items
        $(component.datagrid.getSelectedItems()).each(function (k, v) {
            copiedItems.push(v.objectId);
        });

        if (copiedItems.length > 0) {

            // Enable the paste button only if there is a selected folder
            if (component.moduleComponent.modeler.selectedFolder != null) {
                $(component.objectOptionPaste).addClass("optionBtnEnabled");
            }

            // Show info message
            ManagerPopUp.dialog(ModelApplication.literals.get("INFO", "ManagerApp"), ModelApplication.literals.get("OBJECT_COPY_MESSAGE", "ManagerApp").replace("{n}", copiedItems.length), [
                {
                    label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
                }
            ], {
                className: "info"
            });
        }
        else {
            $(component.objectOptionPaste).removeClass("optionBtnEnabled");
        }
        component.moduleComponent.modeler.copiedItems = copiedItems;
    }
};


/**
 * Paste the previous copied items
 */
ComponentObjects.prototype._objectsPaste = function () {

    // Define this component
    var component = this;

    // Validate if the current module is selected
    if (component.moduleComponent.modeler.isSelected) {
        $(component.objectOptionPaste).removeClass("optionBtnEnabled");
        if (component.moduleComponent.modeler.copiedItems.length > 0) {

            // Call the controller to do the ajax request
            component.moduleComponent.controller.objectsDuplicate();
        }
    }
};


/**
 * Validate if the selected objects can be processed:
 *
 * There is a selected folder?
 * If true, there is a linked folder that matches with the selected one on each object?
 *
 * @returns {boolean}
 */
ComponentObjects.prototype._validateSelectedObjectsToProcess = function () {
    // Define this component
    var component = this;

    if (component.moduleComponent.modeler.selectedFolder != null) {
        var canProcess = true;
        $(component.moduleComponent.modeler.selectedObjects).each(function (k, v) {
            var fidOk = false;
            $(v.folderIds.split(";")).each(function (fKey, fId) {
                if (component.moduleComponent.modeler.selectedFolder.folderId == fId) {
                    fidOk = true;
                    return false;
                }
            });
            canProcess = fidOk;
            return canProcess;
        });
        return canProcess;
    }
    return false;
};


/**
 * Show the export popup
 */
ComponentObjects.prototype._showExportPopUp = function () {
    // Define this component
    var component = this;

    // Initialize the popup
    new ViewExportPopUp(component.moduleComponent);
};


/**
 * Toggle select all (select / unselect)
 */
ComponentObjects.prototype._toggleSelectAll = function () {
    // Define this component
    var component = this;

    // Do the toogle and select / unselect all items on the datagrid
    if ($(component.objectOptionSelectAll).hasClass("selectAllObjectBtn")) {
        $(component.objectOptionSelectAll).removeClass("selectAllObjectBtn");
        $(component.objectOptionSelectAll).addClass("unselectAllObjectBtn");
        $(component.objectOptionSelectAll).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_UNSELECT_ALL", "ManagerApp"));
        component.datagrid.selectAllItems();
    }
    else {
        $(component.objectOptionSelectAll).removeClass("unselectAllObjectBtn");
        $(component.objectOptionSelectAll).addClass("selectAllObjectBtn");
        $(component.objectOptionSelectAll).attr("title", ModelApplication.literals.get("OBJECT_TOOLTIP_SELECT_ALL", "ManagerApp"));
        component.datagrid.unselectAllItems();
    }
};


/**
 * Go to the next page only if possible
 */
ComponentObjects.prototype.goToNextPage = function () {
    // Define this component
    var component = this;

    // Increase the page only if we can
    if (component.moduleComponent.modeler.currentPage < component.moduleComponent.modeler.objectsList.totalPages) {
        component.moduleComponent.modeler.currentPage++;

        // Get the new page
        component.moduleComponent.controller.objectsGet();
    }
};


/**
 * Go to the previous page only if possible
 */
ComponentObjects.prototype.goToPreviousPage = function () {
    // Define this component
    var component = this;

    // Decrease the page only if we can
    if (component.moduleComponent.modeler.currentPage > 0) {
        component.moduleComponent.modeler.currentPage--;

        // Get the new page
        component.moduleComponent.controller.objectsGet();
    }
};