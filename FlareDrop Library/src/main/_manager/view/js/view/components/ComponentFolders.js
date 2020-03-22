function ComponentFolders(moduleComponent) {

    // Get the component object
    var component = this;

    // Get the module component
    component.moduleComponent = moduleComponent;

    // Create the component's container
    component.container = $('<div class="componentFolders"></div>');

    // Create the top folder options
    component.folderOptionsContainer = $('<div class="row bar folderOptionsContainer"></div>');

    component.folderOptionAdd = $('<div class="optionBtn skinIcon addFolderBtn folderOption unselectable"></div>');
    component.folderOptionRemove = $('<div class="optionBtn skinIcon remFolderBtn folderOption unselectable"></div>');
    component.folderOptionEdit = $('<div class="optionBtn skinIcon editFolderBtn folderOption unselectable"></div>');
    component.folderOptionAttach = $('<div class="optionBtn skinIcon attachFolderBtn folderOption unselectable"></div>');
    component.folderOptionExpand = $('<div class="optionBtn skinIcon expandFoldersBtn folderOption optionBtnEnabled unselectable"></div>');
    component.folderOptionClose = $('<div class="optionBtn skinIcon collapseFoldersBtn folderOption optionBtnEnabled unselectable"></div>');

    // Define the tooltips for the options
    $(component.folderOptionAdd).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_NEW", "ManagerApp"));
    $(component.folderOptionRemove).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_REMOVE", "ManagerApp"));
    $(component.folderOptionEdit).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_EDIT", "ManagerApp"));
    $(component.folderOptionAttach).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_ATTACH", "ManagerApp"));
    $(component.folderOptionExpand).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_EXPAND", "ManagerApp"));
    $(component.folderOptionClose).attr("title", ModelApplication.literals.get("FOLDER_TOOLTIP_COLLAPSE", "ManagerApp"));

    // Apply the configuration
    var treeSortable = true;
    if (component.moduleComponent.modeler.configuration.objects.folderOptionsShow != 1) {
        treeSortable = false;
        $(component.folderOptionsContainer).hide();
    }
    else if (component.moduleComponent.modeler.configuration.objects.folderFilesEnabled != 1 && component.moduleComponent.modeler.configuration.objects.folderPicturesEnabled != 1) {
        $(component.folderOptionAttach).hide();
    }

    // Add click events to the folder buttons
    $(component.folderOptionAdd).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showAddFolderPopUp();
        }
    });

    $(component.folderOptionEdit).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showEditFolderPopUp();
        }
    });

    $(component.folderOptionAttach).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showAttatchPopUp();
        }
    });

    $(component.folderOptionRemove).click(function () {
        if ($(this).hasClass("optionBtnEnabled")) {
            component._showRemoveFolderPopUp();
        }
    });

    $(component.folderOptionExpand).click(function () {
        component.tree.expandAll();
    });

    $(component.folderOptionClose).click(function () {
        component.tree.collapseAll();
    });

    // Append the top folder buttons to the container
    $(component.folderOptionsContainer).append(component.folderOptionAdd, component.folderOptionRemove, component.folderOptionEdit, component.folderOptionAttach, component.folderOptionClose, component.folderOptionExpand);

    // Create the folder tree container
    component.folderTreeContainer = $('<div class="row folderTreeContainer unselectable"></div>');

    // Create the folder DynaTree component and append it to the folder container
    component.tree = new ComponentTree(component.folderTreeContainer, component.moduleComponent.modeler.name + "FolderTreeId", component.moduleComponent.modeler.foldersList, "folderId", "name", "child", {sortable: treeSortable}, {
        onSelect: function (node) {
            if (component.moduleComponent.modeler.selectedFolder != node) {
                component.moduleComponent.modeler.selectedFolder = node;
                component.moduleComponent.modeler.selectedParentFolder = component.tree.getParentNode(node.folderId);
                component.topFolderOptionsRefresh();
                component.moduleComponent.modeler.currentPage = 0;
                component.moduleComponent.controller.objectsGet();
            }
        },
        onUnselectAll: function () {

            component.topFolderOptionsRefresh();
            component.moduleComponent.modeler.currentPage = 0;
            component.moduleComponent.controller.objectsGet();
        },
        onSort: function () {

            // Get the selected folder
            var movedFolder = component.tree.lastSortedNode;
            component.moduleComponent.modeler.selectedFolder = movedFolder;

            // Validate if the folder can be sorted or not, depending of the allowed levels
            var allowedLevels = component.moduleComponent.modeler.configuration.objects.folderLevels;
            var treeCurrentLevels = component.tree.getChildrenLevels();

            if (allowedLevels >= treeCurrentLevels) {

                // Get the destination folder
                var destinationFolder = component.tree.getParentNode(movedFolder.folderId);

                // Get the destination folder id
                var destinationFolderId = destinationFolder == null ? null : destinationFolder.folderId;

                // Move folder on the database
                component.moduleComponent.controller.folderMove(movedFolder.folderId, destinationFolderId);

                // Generate the module sorting data
                component.moduleComponent.controller.foldersSort(component.tree.getNodeIndexes());
            }
            else {
                component._folderMoveErrorHandler();
            }
        },
        onOuterItemDrop: function (draggedElement, nodeId) {
            // Set dropped folder id
            component.moduleComponent.modeler.droppedFolderId = nodeId;

            // Show the move/link popup
            component.moduleComponent.viewer.objects.showMoveObjectPopUp();
        },
        onDblClick: function () {
            $(component.folderOptionEdit).trigger("click");
        }
    });

    // Do the appends to the main container
    $(component.container).append(component.folderOptionsContainer, component.folderTreeContainer);

    // Deactivate selected node when clicking out EVENT
    $(component.container).click(function (e) {
        if ($(e.target).hasClass("folderTreeContainer")) {
            if (component.moduleComponent.modeler.selectedFolder != null) {

                component.moduleComponent.modeler.selectedFolder = null;
                component.tree.unselectAllNodes();
            }
        }
    });

    // Refresh the folder list for first time
    component.reloadFolders();

    // EVENT LISTENERS
    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_SET_SUCCESS, function () {
        component._folderSetSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_SET_ERROR, function () {
        component._folderSetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDERS_GET_SUCCESS, function () {
        component._foldersGetSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDERS_GET_ERROR, function () {
        component._foldersGetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_REMOVE_SUCCESS, function () {
        component._folderRemoveSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_REMOVE_ERROR, function () {
        component._folderRemoveErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_GET_SUCCESS, function () {
        component._folderGetSuccesHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_GET_ERROR, function () {
        component._folderGetErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_MOVE_SUCCESS, function () {
        component._folderMoveSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_MOVE_ERROR, function () {
        component._folderMoveErrorHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_SORT_SUCCESS, function () {
        component._folderSortSuccessHandler();
    });

    ManagerEvent.addEventListener(component.moduleComponent, component.moduleComponent.modeler.EVENT_FOLDER_SORT_ERROR, function () {
        component._folderSortErrorHandler();
    });
}


/**
 * Refresh top folder option buttons to be enabled / disabled
 */
ComponentFolders.prototype.topFolderOptionsRefresh = function () {
    // Define this component
    var component = this;

    // Get the current selected folder
    var selectedFolder = component.moduleComponent.modeler.selectedFolder;

    if (selectedFolder != null) {
        component.folderOptionEdit.addClass("optionBtnEnabled");
        component.folderOptionAttach.addClass("optionBtnEnabled");

        if (selectedFolder.level + 1 > component.moduleComponent.modeler.configuration.objects.folderLevels) {
            component.folderOptionAdd.removeClass("optionBtnEnabled");
        }
        else {
            component.folderOptionAdd.addClass("optionBtnEnabled");
        }

        // Validate writing privileges
        if (selectedFolder.privilegeId != ModelApplication.privilegeWriteId) {
            component.folderOptionRemove.removeClass("optionBtnEnabled");
        }
        else {
            component.folderOptionRemove.addClass("optionBtnEnabled");
        }
    }
    else {
        // If no folders selected, create is enabled by default and remove/edit is disabled
        component.folderOptionAdd.addClass("optionBtnEnabled");
        component.folderOptionEdit.removeClass("optionBtnEnabled");
        component.folderOptionAttach.removeClass("optionBtnEnabled");
        component.folderOptionRemove.removeClass("optionBtnEnabled");
    }
};


/**
 * Reload tree folders
 */
ComponentFolders.prototype.reloadFolders = function () {
    // Get the component object
    var component = this;

    // Rebuild the dynatree element
    component.tree.updateData(component.moduleComponent.modeler.foldersList);

    // Auto select first folder if foldersShow is disabled
    if (component.moduleComponent.modeler.configuration.objects.foldersShow != 1 && component.moduleComponent.modeler.foldersList.length > 0) {
        component.moduleComponent.modeler.selectedFolder = component.moduleComponent.modeler.foldersList[0];
        component.moduleComponent.controller.objectsGet();
        return;
    }

    // Select previous selected folder on the tree only if there is a selected one and refresh the objects list
    if (component.moduleComponent.modeler.selectedFolder != null) {
        component.tree.selectNode(component.moduleComponent.modeler.selectedFolder.folderId, true);
    }
    else {
        component.moduleComponent.controller.objectsGet();
    }

    // Refresh top folder options
    component.topFolderOptionsRefresh();
};


/**
 * Show folder add PopUp
 */
ComponentFolders.prototype._showAddFolderPopUp = function () {
    // Define this component
    var component = this;

    new ViewFolderEditPopUp(component.moduleComponent, undefined);
};


/**
 * Show folder edit PopUp
 */
ComponentFolders.prototype._showEditFolderPopUp = function () {
    // Define this component
    var component = this;

    // Define the action to apply when the folder is received
    component.moduleComponent.attachOrEdit = "EDIT";

    // Call the controller to get the cateogory object
    component.moduleComponent.controller.folderGet(component.moduleComponent.modeler.selectedFolder.folderId);
};


/**
 * Show attatch PopUp
 */
ComponentFolders.prototype._showAttatchPopUp = function () {
    // Define this component
    var component = this;

    // Define the action to apply when the object is received
    component.moduleComponent.attachOrEdit = "ATTACH";

    // Call the controller to get the folder object
    component.moduleComponent.controller.folderGet(component.moduleComponent.modeler.selectedFolder.folderId);
};


/**
 * Show folder remove confirmation dialog
 */
ComponentFolders.prototype._showRemoveFolderPopUp = function () {
    // Define this component
    var component = this;

    // Show the popup
    ManagerPopUp.dialog(ModelApplication.literals.get("ALERT", "ManagerApp"), ModelApplication.literals.get("FOLDER_REMOVE_SURE", "ManagerApp") + " <b>" + component.moduleComponent.modeler.selectedFolder.name + "</b>", [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp"),
            action: function () {
                // Call the controller to do the operation
                component.moduleComponent.controller.folderRemove(component.moduleComponent.modeler.selectedFolder.folderId);
            }
        },
        {
            label: ModelApplication.literals.get("CANCEL", "ManagerApp")
        }
    ], {
        className: "warning"
    });
};


/**
 * Show the folder edit window when a folder is getted from the database
 */
ComponentFolders.prototype._folderGetSuccesHandler = function () {

    // Define the component
    var component = this;

    if (component.moduleComponent.attachOrEdit == "EDIT") {
        // Show the edit popUp with all folder data filled
        new ViewFolderEditPopUp(component.moduleComponent, component.moduleComponent.modeler.folderGet);
    }

    if (component.moduleComponent.attachOrEdit == "ATTACH") {
        // Show the attatch popUp with all folder data filled
        new ViewAttachPopUp(component.moduleComponent, component.moduleComponent.modeler.folderGet, "folder");
    }

    // Remove the action to apply if it's not an attach request
    if (component.moduleComponent.attachOrEdit != "ATTACH_REQUEST") {
        component.moduleComponent.attachOrEdit = null;
    }
};


/**
 * Cancel showing the categoty edit window because it failed on getting the folder to be edited
 */
ComponentFolders.prototype._folderGetErrorHandler = function () {

    // Show the error notification
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDER_GET_ERROR", "ManagerApp"), [
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
 * Folder set success handler
 */
ComponentFolders.prototype._folderSetSuccessHandler = function () {

    // Define the component
    var component = this;

    ManagerPopUp.closeAll();
    component.moduleComponent.controller.foldersGet();
};


/**
 * Folder set error handler
 */
ComponentFolders.prototype._folderSetErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDER_SET_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * On folder remove success
 */
ComponentFolders.prototype._folderRemoveSuccessHandler = function () {
    // Define this component
    var component = this;

    // Set the selected folder as the parent of the removed one, and get the new parent
    component.moduleComponent.modeler.selectedFolder = component.moduleComponent.modeler.selectedParentFolder;

    if (component.moduleComponent.modeler.selectedFolder != null) {
        component.moduleComponent.modeler.selectedParentFolder = component.tree.getParentNode(component.moduleComponent.modeler.selectedFolder.folderId);
    }
    else {
        // Set selected parent folder as null
        component.moduleComponent.modeler.selectedParentFolder = null;
    }

    // Update the folder list
    component.moduleComponent.controller.foldersGet();
};


/**
 * On folder remove error
 */
ComponentFolders.prototype._folderRemoveErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDER_REMOVE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * On folder move error
 */
ComponentFolders.prototype._folderMoveErrorHandler = function () {

    // Define this component
    var component = this;

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDER_MOVE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {
        component.moduleComponent.controller.foldersGet();
    });
};


/**
 * On folder move success
 */
ComponentFolders.prototype._folderMoveSuccessHandler = function () {

    // Define this component
    var component = this;

    component.moduleComponent.controller.foldersGet();
};


/**
 * On folder sort error
 */
ComponentFolders.prototype._folderSortErrorHandler = function () {

    // Define this component
    var component = this;

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDER_SORT_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {

        component.moduleComponent.controller.foldersGet();
    });
};


/**
 * On folder sort success
 */
ComponentFolders.prototype._folderSortSuccessHandler = function () {


};


/**
 * Folders get success event handler
 */
ComponentFolders.prototype._foldersGetSuccessHandler = function () {

    // Define this component
    var component = this;

    component.reloadFolders();
};


/**
 * Folders get error event handler
 */
ComponentFolders.prototype._foldersGetErrorHandler = function () {

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("FOLDERS_GET_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};