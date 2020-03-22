function ControlModule(moduleComponent) {

    // Define this control
    var control = this;

    // Get the module component
    control.moduleComponent = moduleComponent;

    // Set the default disk and auto refresh the module data
    control.setDisk(control.moduleComponent.modeler.configuration.filters.diskDefault);

    // EVENT LISTENER FOR CATEGORIES WHEN REFRESHING THE MODULE
    ManagerEvent.addEventListener(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDERS_GET_SUCCESS, function () {
        if (control.moduleComponent.modeler.isRefreshing) {
            control._validateRefresh();
        }
    });
}


/**
 * Get a folder object by its id
 *
 * @param folderId The folder Id
 */
ControlModule.prototype.folderGet = function (folderId) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFolderGet = {
        folderId: folderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFolderGetUrl, "ajaxFolderGet", "isGettingFolder", control.moduleComponent.modeler.EVENT_FOLDER_GET_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == null) {

            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_GET_ERROR);
        }
        else {

            // Store the folder object to the module's model
            control.moduleComponent.modeler.folderGet = control.moduleComponent.modeler.lastRequestData;

            // Dispatch de success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_GET_SUCCESS);
        }
    }, "json", "getFolderAgain");
};


/**
 * Set a folder object
 *
 * @param folderData The JSON generated folder data
 */
ControlModule.prototype.folderSet = function (folderData) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFolderSet = {
        folderData: folderData
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFolderSetUrl, "ajaxFolderSet", "isSettingFolder", control.moduleComponent.modeler.EVENT_FOLDER_SET_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {

            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_SET_SUCCESS);
        }
        else {

            // Dispatch de success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_SET_ERROR);
        }
    }, "text");
};


/**
 * Get the folders list
 */
ControlModule.prototype.foldersGet = function () {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFoldersGet = {
        lanTag: GLOBAL_CURRENT_LAN_TAG,
        parentFolderId: "",
        diskId: control.moduleComponent.modeler.selectedDisk,
        getVisible: false,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFoldersGetUrl, "ajaxFoldersGet", "isGettingFolders", control.moduleComponent.modeler.EVENT_FOLDERS_GET_ERROR, function () {

        // Store the folders list to the module's model
        control.moduleComponent.modeler.foldersList = control.moduleComponent.modeler.lastRequestData;

        // Dispatch success event
        ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDERS_GET_SUCCESS);
    }, "json", "getFoldersAgain");
};


/**
 * Remove a set of folders by its ids
 *
 * @param folderId Folder id to be removed
 */
ControlModule.prototype.folderRemove = function (folderId) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFolderRemove = {
        folderId: folderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFolderRemoveUrl, "ajaxFolderRemove", "isRemovingFolder", control.moduleComponent.modeler.EVENT_FOLDER_REMOVE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_REMOVE_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_REMOVE_ERROR);
        }
    }, "text");
};


/**
 * Move a folder to another one
 *
 * @param sourceFolderId The source folder id
 * @param destinationFolderId THe destination folder id
 */
ControlModule.prototype.folderMove = function (sourceFolderId, destinationFolderId) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFolderMove = {
        sourceFolderId: sourceFolderId,
        destinationFolderId: destinationFolderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFolderMoveUrl, "ajaxFolderMove", "isMovingFolder", control.moduleComponent.modeler.EVENT_FOLDER_MOVE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_MOVE_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_MOVE_ERROR);
        }
    }, "text");
};


/**
 * Sort the folders as the tree
 *
 * @param sortData Object containing the folder id as the key, and the sorting index on each value
 */
ControlModule.prototype.foldersSort = function (sortData) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFoldersSort = {
        sortData: UtilsConversion.objectToJson(sortData)
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFoldersSortUrl, "ajaxFoldersSort", "isSortingFolders", control.moduleComponent.modeler.EVENT_FOLDER_SORT_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_SORT_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FOLDER_SORT_ERROR);
        }
    }, "text");
};


/**
 * Get the objects list from the database
 */
ControlModule.prototype.objectsGet = function () {
    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxObjectsGet = {
        filterData: UtilsConversion.objectToJson(control._generateObjectsGetFilter()),
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsGetUrl, "ajaxObjectsGet", "isGettingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_GET_ERROR, function () {

        // Store the objects list to the module's model
        control.moduleComponent.modeler.objectsList = control.moduleComponent.modeler.lastRequestData;

        // Dispatch success event
        ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_GET_SUCCESS);
    }, "json", "getObjectsAgain");
};


/**
 * Get an object from the database
 *
 * @param objectId The object id that we want to get
 */
ControlModule.prototype.objectGet = function (objectId) {
    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxGet = {
        objectId: objectId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectGetUrl, "ajaxGet", "isGettingObject", control.moduleComponent.modeler.EVENT_OBJECT_GET_ERROR, function () {

        // Convert the received data and store it on the module's model
        control.moduleComponent.modeler.objectGet = control.moduleComponent.modeler.lastRequestData;

        // Dispatch success event
        ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECT_GET_SUCCESS);
    }, "json", "getObjectAgain");
};


/**
 * Set an object to the database
 *
 * @param objectData The JSON generated object data
 */
ControlModule.prototype.objectSet = function (objectData) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxSet = {
        objectData: objectData,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectSetUrl, "ajaxSet", "isSettingObject", control.moduleComponent.modeler.EVENT_OBJECT_SET_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {

            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECT_SET_SUCCESS);
        }
        else {

            // Dispatch de success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECT_SET_ERROR);
        }
    }, "text");
};


/**
 * Move a set of objects from a folder to another one
 */
ControlModule.prototype.objectsMove = function () {

    // Define this control
    var control = this;

    // Get the selected object ids to remove
    var ids = [];

    $(control.moduleComponent.modeler.selectedObjects).each(function (k, object) {
        ids.push(object[control.moduleComponent.modeler.primaryKey]);
    });

    // Save the ajax data
    control.moduleComponent.modeler.ajaxMove = {
        ids: UtilsConversion.objectToJson(ids),
        folderIdFrom: control.moduleComponent.modeler.selectedFolder.folderId,
        folderIdTo: control.moduleComponent.modeler.droppedFolderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsMoveUrl, "ajaxMove", "isMovingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_MOVE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_MOVE_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_MOVE_ERROR);
        }
    }, "text");
};


/**
 * Link a set of objects to a folder
 */
ControlModule.prototype.objectsLink = function () {

    // Define this control
    var control = this;

    // Get the selected object ids to remove
    var ids = [];

    $(control.moduleComponent.modeler.selectedObjects).each(function (k, object) {
        ids.push(object[control.moduleComponent.modeler.primaryKey]);
    });

    // Save the ajax data
    control.moduleComponent.modeler.ajaxLink = {
        ids: UtilsConversion.objectToJson(ids),
        folderId: control.moduleComponent.modeler.droppedFolderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsLinkUrl, "ajaxLink", "isLinkingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_LINK_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_LINK_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_LINK_ERROR);
        }
    }, "text");
};


/**
 * Remove an object from the database
 */
ControlModule.prototype.objectsRemove = function () {

    // Define this control
    var control = this;

    // Get the selected object ids to remove
    var ids = [];

    $(control.moduleComponent.modeler.selectedObjects).each(function (k, object) {
        ids.push(object[control.moduleComponent.modeler.primaryKey]);
    });

    // Save the ajax data
    control.moduleComponent.modeler.ajaxRemove = {
        ids: UtilsConversion.objectToJson(ids),
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsRemoveUrl, "ajaxRemove", "isRemovingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_REMOVE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            // Dispatch success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_REMOVE_SUCCESS);
        }
        else {
            // Dispatch error event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_REMOVE_ERROR);
        }
    }, "text");
};


/**
 * Unlink a set of objects from a folder
 */
ControlModule.prototype.objectsUnlink = function () {

    // Define this control
    var control = this;

    // Get the selected object ids to remove
    var ids = [];

    $(control.moduleComponent.modeler.selectedObjects).each(function (k, object) {
        ids.push(object[control.moduleComponent.modeler.primaryKey]);
    });

    // Save the ajax data
    control.moduleComponent.modeler.ajaxUnlink = {
        ids: UtilsConversion.objectToJson(ids),
        folderId: control.moduleComponent.modeler.selectedFolder.folderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsUnlinkUrl, "ajaxUnlink", "isUnlinkingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_UNLINK_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            // Dispatch success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_UNLINK_SUCCESS);
        }
        else {
            // Dispatch error event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_UNLINK_ERROR);
        }
    }, "text");

};


/**
 * Get the objects list columns (NOT FOR USERS!)
 */
ControlModule.prototype.objectsColumnsGet = function () {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxObjectsColumnsGet = {
        filterData: UtilsConversion.objectToJson(control._generateObjectsGetFilter()),
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsColumnsGetUrl, "ajaxObjectsColumnsGet", "isGettingColumnsObjects", control.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_ERROR, function () {

        // Convert the received data and store it on the module's model
        control.moduleComponent.modeler.objectsColumnsGet = control.moduleComponent.modeler.lastRequestData;

        // Dispatch success event
        ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_COLUMNS_GET_SUCCESS);
    }, "json", "getObjectsColumnsAgain");
};


/**
 * Get a CSV from the objects list from the database and open the file in a new tab (NOT FOR USERS!)
 *
 * @param csvColumns The columns that we want to export
 */
ControlModule.prototype.objectsCsvGet = function (csvColumns) {
    // Define this control
    var control = this;

    // Do the get call and open it in a new tab
    UtilsHttp.goToUrl(control.moduleComponent.modeler.serviceObjectsCsvGetUrl + "&" + UtilsHttp.encodeParams({
            filterData: UtilsConversion.objectToJson(control._generateObjectsGetFilter(false)),
            objectType: control.moduleComponent.modeler.name,
            csvColumns: UtilsConversion.objectToJson(csvColumns),
            csvDelimiter: ';',
            csvEnclosure: '"'
        }), true);
};


/**
 * Duplicate the selected items (NOT FOR USERS!)
 */
ControlModule.prototype.objectsDuplicate = function () {
    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxDuplicate = {
        ids: UtilsConversion.objectToJson(control.moduleComponent.modeler.copiedItems),
        folderId: control.moduleComponent.modeler.selectedFolder.folderId,
        objectType: control.moduleComponent.modeler.name
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceObjectsDuplicateUrl, "ajaxDuplicate", "isDuplicatingObjects", control.moduleComponent.modeler.EVENT_OBJECTS_DUPLICATE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_DUPLICATE_SUCCESS);
        }
        else {
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_OBJECTS_DUPLICATE_ERROR);
        }
    }, "text");
};


/**
 * Remove files from an object or folder
 *
 * @param fileIds An array containing the file ids to be removed
 */
ControlModule.prototype.filesRemove = function (fileIds) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFilesRemove = {
        fileIds: UtilsConversion.objectToJson(fileIds)
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFilesRemoveUrl, "ajaxFilesRemove", "isRemovingFilesObject", control.moduleComponent.modeler.EVENT_FILES_REMOVE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            // Dispatch success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FILES_REMOVE_SUCCESS);
        }
        else {
            // Dispatch error event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FILES_REMOVE_ERROR);
        }
    }, "text");
};


/**
 * Set a file as private or public
 *
 * @param fileId The file id to operate
 * @param isPrivate Boolean to set the file as private or not
 */
ControlModule.prototype.filePrivateSet = function (fileId, isPrivate) {

    // Define this control
    var control = this;

    // Save the ajax data
    control.moduleComponent.modeler.ajaxFileSetPrivate = {
        fileId: fileId,
        isPrivate: isPrivate
    };

    // Do the ajax request
    control.ajaxRequest(control.moduleComponent.modeler.serviceFilePrivateSet, "ajaxFileSetPrivate", "isSettingFilePrivate", control.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_ERROR, function () {

        if (control.moduleComponent.modeler.lastRequestData == "") {
            // Dispatch success event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_SUCCESS);
        }
        else {
            // Dispatch error event
            ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_ERROR);
        }
    }, "text");
};


/**
 * Send an AJAX request
 *
 * @param url The service URL
 * @param sendData The data to send by POST as name stored on the module's model
 * @param requestState The request state name stored on the module's model
 * @param eventError The error event name. The event bust will be the module component
 * @param successAction The action function on success
 * @param dataType The result data type
 * @param again The recall again name stored on the module's model (It is used basically on the text search filter when multiple same ajax requests are requested). NOT MANDATORY
 */
ControlModule.prototype.ajaxRequest = function (url, sendData, requestState, eventError, successAction, dataType, again) {

    // Define this component
    var control = this;

    if (!control.moduleComponent.modeler[requestState]) {

        // Set application as waiting
        ViewApplication.wait();

        // Set request state as requesting
        control.moduleComponent.modeler[requestState] = true;

        // Do the HTTP request
        $.ajax({
            method: "POST",
            dataType: dataType || "html",
            url: url,
            data: control.moduleComponent.modeler[sendData],
            timeout: ModelApplication.ajaxTimeOut,
            cache: false,
            success: function (data) {

                // Store the received data to the module's model
                control.moduleComponent.modeler.lastRequestData = data;

                // Apply the success action
                successAction.apply();
            },
            error: function (e) {

                if (e.statusText == "timeout") {

                    // Set requesting state as not requesting
                    control.moduleComponent.modeler[requestState] = false;

                    // Re-call the request
                    control.ajaxRequest(url, sendData, requestState, eventError, successAction, dataType, again);
                }
                else {

                    // Dispatch de error event
                    ManagerEvent.dispatch(control.moduleComponent, eventError);
                }
            },
            complete: function () {

                // Set requesting state as not requesting
                control.moduleComponent.modeler[requestState] = false;

                // Recall the method if requested and defined
                if (again !== undefined) {
                    if (control.moduleComponent.modeler[again]) {
                        // Re-call the request
                        control.ajaxRequest(url, sendData, requestState, eventError, successAction, dataType, again);

                        // Set recall again to false
                        control.moduleComponent.modeler[again] = false;
                    }
                }

                // Set application as not waiting
                ViewApplication.closeWait();
            }
        });
    }
    else {
        // Set recall to true only if another request is defined
        if (again !== undefined) {
            control.moduleComponent.modeler[again] = true;
        }
    }
};


/**
 * Select the module's disk
 *
 * @param index The disk index
 */
ControlModule.prototype.setDisk = function (index) {

    // Define this control
    var control = this;

    // Modify the disk
    control.moduleComponent.modeler.selectedDisk = index;

    // Refresh the module
    control.refresh();
};


/**
 * Generate a objects get filter through the modeler states
 *
 * @param usePagination Boolean that tells if the filter applies the pagination or not. (true by default)
 *
 * @returns {VoSystemFilter}
 */
ControlModule.prototype._generateObjectsGetFilter = function (usePagination) {
    // Define this control
    var control = this;

    // Set the defaults
    usePagination = usePagination || true;

    // Define the filter
    var filter = new VoSystemFilter();

    // Set the sort fields
    filter.setSortFields(control.moduleComponent.modeler.sortObjectsBy[0], control.moduleComponent.modeler.sortObjectsBy[1]);

    // Filter by the application selected literal except the users
    if (control.moduleComponent.modeler.name != "user") {
        filter.setLanTag(ModelApplication.selectedLanTag);
        filter.setAND();
    }

    // Filter by selected disk
    filter.setDiskId(control.moduleComponent.modeler.selectedDisk);

    // Filter by the root id
    filter.setAND();
    filter.setRootId(ModelApplication.rootId);

    // Filter by the selected folder
    if (control.moduleComponent.modeler.selectedFolder != null) {
        filter.setAND();
        filter.setFolderId(control.moduleComponent.modeler.selectedFolder.folderId);
    }

    // Filter by text search
    if (control.moduleComponent.modeler.filterTextSearch != "") {

        var propertiesToApply = control.moduleComponent.modeler.configuration.filters.showTextProperties.split(";");

        // Set AND
        filter.setAND();

        // Open parenthesis to insert the ORS inside
        filter.setOpenParenthesis();

        // Insert the filter ORS
        $(propertiesToApply).each(function (k, property) {
            filter.setPropertySearch(property, control.moduleComponent.modeler.filterTextSearch);
            if (k < propertiesToApply.length - 1) {
                filter.setOR();
            }
        });

        // Close parenthesis
        filter.setCloseParenthesis();
    }

    // Filter by period
    if (control.moduleComponent.modeler.selectedPeriod != null) {
        filter.setPropertyInner("creationDate", control.moduleComponent.modeler.selectedPeriod[0], control.moduleComponent.modeler.selectedPeriod[1], "DATE");
    }

    // Filter by pagination
    if (usePagination) {
        filter.setPageCurrent(control.moduleComponent.modeler.currentPage);
        filter.setPageNumItems(control.moduleComponent.modeler.pageNumItems);
    }

    // Return the filter object
    return filter;
};


/**
 * Refresh all of this module data
 */
ControlModule.prototype.refresh = function () {

    // Define this control
    var control = this;

    // Set state as refreshing
    control.moduleComponent.modeler.isRefreshing = true;

    // Reset the refresh state array
    control.moduleComponent.modeler.refreshStates = [];

    // Unselect the folder and the objects
    control.moduleComponent.modeler.selectedFolder = null;
    control.moduleComponent.modeler.selectedParentFolder = null;
    control.moduleComponent.modeler.selectedObjects = [];

    // Get the folder and objects list
    control.foldersGet();
};


/**
 * Validate if the module refreshing transaction is completed
 */
ControlModule.prototype._validateRefresh = function () {
    // Define this control
    var control = this;

    // Set state as not refreshing
    control.moduleComponent.modeler.isRefreshing = false;

    // Define the module VIEWER only if it's not created
    if (!control.moduleComponent.modeler.isCreated) {

        control.moduleComponent.viewer = new ViewModule(control.moduleComponent);
        control.moduleComponent.modeler.isCreated = true; // Set the module as created

        // Dispatch the module create event
        ManagerEvent.dispatch(control.moduleComponent, control.moduleComponent.modeler.EVENT_MODULE_CREATE_SUCCESS);
    }
};