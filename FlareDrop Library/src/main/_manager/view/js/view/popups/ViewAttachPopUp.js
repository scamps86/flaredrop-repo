/**
 * Attach PopUp
 *
 * @param moduleComponent The module component
 * @param objectData The object data (folder or object)
 * @param objectKind The object kind ("folder" or "object")
 */
function ViewAttachPopUp(moduleComponent, objectData, objectKind) {

    // Declare this view
    var view = this;

    // Define the object data (folder or object)
    view.objectData = objectData;

    // Define the object kind (folder or object)
    view.objectKind = objectKind;

    // Save the module component
    view.moduleComponent = moduleComponent;

    // Reloading data state
    view.isReloadingData = 0;

    // Pictures/files to remove
    view.picturesToRemove = [];
    view.filesToRemove = [];

    // Uploading states
    view.isUploadingPictures = false;
    view.isUploadingFiles = false;

    // Modified states
    view.isFormPicturesModified = false;
    view.isFormFilesModified = false;

    // Selected locker element (used on the file set private success handler)
    view.lastLocker = null;

    // Create the PopUp window
    var dialogTitle = ModelApplication.literals.get("ATTACH", "ManagerApp") + ": ";

    switch (view.objectKind) {
        case "folder":
            dialogTitle += ModelApplication.literals.get("ATTACH_TITLE_FOLDER", "ManagerApp") + " (id " + view.objectData.folderId + ")";
            break;
        case "object":
            dialogTitle += ModelApplication.literals.get("ATTACH_TITLE_OBJECT", "ManagerApp") + " (id " + view.objectData.objectId + ")";
            break;
    }

    // Create the forms
    view.formPictures = $('<form class="row attachPopUp" id="formPictures" serviceUrl="' + moduleComponent.modeler.serviceFilesSetUrl + '" filesQuantity="5"><input type="hidden" name="fileType" value="picture"></form>');
    view.formFiles = $('<form class="row attachPopUp" id="formFiles" serviceUrl="' + moduleComponent.modeler.serviceFilesSetUrl + '" filesQuantity="5"><input type="hidden" name="fileType" value="file"></form>');

    // Create the popup
    view.w = ManagerPopUp.window(dialogTitle, "", {
        width: 600,
        maxHeight: 600
    }, function () {
        // Abort on closing this window
        ManagerForm.abort(view.formPictures);
        ManagerForm.abort(view.formFiles);

        // Reset the attachOrEdit state
        view.moduleComponent.attachOrEdit = null;

        // Remove the event listeners
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECT_GET_SUCCESS, view.functionObjectGetSuccess);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECT_GET_ERROR, view.functionObjectGetError);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FOLDER_GET_SUCCESS, view.functionFolderGetSuccess);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FOLDER_GET_ERROR, view.functionFolderGetError);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_PICTURES_REMOVE_SUCCESS);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_PICTURES_REMOVE_ERROR);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILES_REMOVE_SUCCESS);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILES_REMOVE_ERROR);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_SUCCESS);
        ManagerEvent.removeEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_ERROR);

        // Refresh the list
        view.moduleComponent.controller.objectsGet();
    });

    // Create files/pictures selector
    view.topSelectorContainer = $('<div class="row attachPopUpTopSelectorContainer"></div>');

    view.typeChooser = new ComponentOptionBar(view.topSelectorContainer, [
        {label: ModelApplication.literals.get("ATTACH_PICTURES", "ManagerApp"), value: "PICTURES"},
        {label: ModelApplication.literals.get("ATTACH_FILES", "ManagerApp"), value: "FILES"}
    ], function (v) {
        view.typeSelect(v);
    });

    // Define the add buttons
    var addPicturesBtn = $('<div class="row"><input type="button" class="componentFormFileSelector" validate="fileSize;fileType" validateCondition="AND" validateFileSize="5120" validateFileType="image/jpeg;image/png" validateErrorMessage="' + ModelApplication.literals.get("ATTACH_PICTURES_INPUT_ERROR", "ManagerApp") + ';' + ModelApplication.literals.get("ALERT", "ManagerApp") + '" value="+ ' + ModelApplication.literals.get("ATTACH_SEARCH_PICTURES", "ManagerApp") + '"><p class="componentFormFileSelectorMessage fontBold">' + ModelApplication.literals.get("ATTACH_UPLOADING_FILES", "ManagerApp") + '</p></div>');
    var addFilesBtn = $('<div class="row"><input type="button" class="componentFormFileSelector" validate="fileSize" validateCondition="AND" validateFileSize="102400" validateErrorMessage="' + ModelApplication.literals.get("ATTACH_FILES_INPUT_ERROR", "ManagerApp") + ';' + ModelApplication.literals.get("ALERT", "ManagerApp") + '" value="+ ' + ModelApplication.literals.get("ATTACH_SEARCH_FILES", "ManagerApp") + '"><p class="componentFormFileSelectorMessage fontBold">' + ModelApplication.literals.get("ATTACH_UPLOADING_FILES", "ManagerApp") + '</div>');

    // Define the preview and attached containers
    var picturesPreviewContainer = $('<div class="filesContainer componentFormFilesPreview"></div>');
    var filesPreviewContainer = $('<div class="filesContainer componentFormFilesPreview"></div>');

    view.picturesAttachedContainer = $('<div class="filesContainer filesAttachedContainer"><p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_PICTURES", "ManagerApp") + '</p></div>');
    view.filesAttachedContainer = $('<div class="filesContainer filesAttachedContainer"><p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_FILES", "ManagerApp") + '</p></div>');

    // Define the progress bar containers
    var picturesProgressBarContainer = $('<div class="row componentFormProgressBar"></div>');
    var filesProgressBarContainer = $('<div class="row componentFormProgressBar"></div>');

    // If the progress bar is 100%, show processing files message
    var intId = setInterval(function () {
        // Stop the interval if the popup is closed
        if (!$(view.w).parents().last().is(document.documentElement)) {
            clearInterval(intId);
        }

        if ($(picturesProgressBarContainer).find("p").html() == "100%") {
            $(picturesProgressBarContainer).find("p").html(ModelApplication.literals.get("ATTACH_PICTURES_PROCESSING", "ManagerApp"));
        }
        if ($(filesProgressBarContainer).find("p").html() == "100%") {
            $(filesProgressBarContainer).find("p").html(ModelApplication.literals.get("ATTACH_FILES_PROCESSING", "ManagerApp"));
        }
    }, 1000);

    // Append the buttons, preview containers and progress bar containers to the forms
    $(view.formPictures).append(addPicturesBtn, picturesPreviewContainer, picturesProgressBarContainer, view.picturesAttachedContainer);
    $(view.formFiles).append(addFilesBtn, filesPreviewContainer, filesProgressBarContainer, view.filesAttachedContainer);

    // Append the forms to the window
    $(view.w).append(view.topSelectorContainer, view.formPictures, view.formFiles);

    // Create and append the hidden inputs to send the params
    var hiddenInputDimensions = $('<input type="hidden" name="dimensions" value="' + view.moduleComponent.modeler.configuration.objects.pictureDimensions + '">');
    var hiddenInputQuality = $('<input type="hidden" name="quality" value="' + view.moduleComponent.modeler.configuration.objects.pictureQuality + '">');

    switch (view.objectKind) {
        case "folder" :
            var hiddenInputFolderId = $('<input type="hidden" name="folderId" value="' + view.objectData.folderId + '">');
            $(view.formPictures).append(hiddenInputFolderId, hiddenInputDimensions, hiddenInputQuality);
            $(view.formFiles).append($(hiddenInputFolderId).clone());
            break;
        case "object" :
            var hiddenInputObjectId = $('<input type="hidden" name="objectId" value="' + view.objectData.objectId + '">');
            $(view.formPictures).append(hiddenInputObjectId, hiddenInputDimensions, hiddenInputQuality);
            $(view.formFiles).append($(hiddenInputObjectId).clone());
            break;
    }

    // Create submit buttons. By default are hidden
    view.picturesSubmitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("ATTACH_SAVE_CHANGES", "ManagerApp") + '">');
    view.filesSubmitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("ATTACH_SAVE_CHANGES", "ManagerApp") + '">');

    // Append submit buttons to the forms
    $(view.formPictures).append(view.picturesSubmitBtn);
    $(view.formFiles).append(view.filesSubmitBtn);

    // Select the pictures as default
    view.typeChooser.selectIndex(0);

    // Add the forms to the form manager
    ManagerForm.add(view.formPictures, function () {
        view._uploadSuccessHandler("formPictures");
    }, function () {
        view._uploadErrorHandler("formPictures");
    }, function () {
        view._uploadStartHandler("formPictures");
    }, function () {
        // cancel
    });
    ManagerForm.add(view.formFiles, function () {
        view._uploadSuccessHandler("formFiles");
    }, function () {
        view._uploadErrorHandler("formFiles");
    }, function () {
        view._uploadStartHandler("formFiles");
    }, function () {
        // cancel
    });

    // Update the forms
    view.update();

    // Define functions for the events
    view.functionObjectGetSuccess = function () {
        view._requestReloadDataSuccessHandler("object");
    };
    view.functionObjectGetError = function () {
        view._requestReloadDataErrorHandler("object");
    };
    view.functionFolderGetSuccess = function () {
        view._requestReloadDataSuccessHandler("folder");
    };
    view.functionFolderGetError = function () {
        view._requestReloadDataErrorHandler("folder");
    };

    // Define the event listeners
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECT_GET_SUCCESS, view.functionObjectGetSuccess);
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_OBJECT_GET_ERROR, view.functionObjectGetError);
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FOLDER_GET_SUCCESS, view.functionFolderGetSuccess);
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FOLDER_GET_ERROR, view.functionFolderGetError);
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_PICTURES_REMOVE_SUCCESS, function () {
        view._removeRequestSuccessHandler();
    });
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_PICTURES_REMOVE_ERROR, function () {
        view._removeRequestErrorHandler();
    });
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILES_REMOVE_SUCCESS, function () {
        view._removeRequestSuccessHandler();
    });
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILES_REMOVE_ERROR, function () {
        view._removeRequestErrorHandler();
    });
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_SUCCESS, function () {
        view._fileSetPrivateSuccessHandler();
    });
    ManagerEvent.addEventListener(view.moduleComponent, view.moduleComponent.modeler.EVENT_FILE_SET_PRIVATE_ERROR, function () {
        view._fileSetPrivateErrorHandler();
    });

    // On add click event, enable save changes button
    $(addPicturesBtn).click(function () {
        $(view.picturesSubmitBtn).show();
    });
    $(addFilesBtn).click(function () {
        $(view.filesSubmitBtn).show();
    });

    // Read the configuration to show or hide the images or files tab
    if (view.objectKind == "folder") {
        if (view.moduleComponent.modeler.configuration.objects.folderFilesEnabled == 1 && view.moduleComponent.modeler.configuration.objects.folderPicturesEnabled != 1) {
            view.typeSelect("FILES");
            $(view.topSelectorContainer).hide();
        } else if (view.moduleComponent.modeler.configuration.objects.folderFilesEnabled != 1 && view.moduleComponent.modeler.configuration.objects.folderPicturesEnabled == 1) {
            view.typeSelect("PICTURES");
            $(view.topSelectorContainer).hide();
        }
    }
    else if (view.objectKind == "object") {
        if (view.moduleComponent.modeler.configuration.objects.filesEnabled == 1 && view.moduleComponent.modeler.configuration.objects.picturesEnabled != 1) {
            view.typeSelect("FILES");
            $(view.topSelectorContainer).hide();
        } else if (view.moduleComponent.modeler.configuration.objects.filesEnabled != 1 && view.moduleComponent.modeler.configuration.objects.picturesEnabled == 1) {
            view.typeSelect("PICTURES");
            $(view.topSelectorContainer).hide();
        }
    }
}


/**
 * Select the PopUp type
 *
 * @param type The literal to be selected
 */
ViewAttachPopUp.prototype.typeSelect = function (type) {
    // Define this view
    var view = this;

    // Show or hide input names and descriptions
    if (type == "PICTURES") {
        $(view.formPictures).show();
        $(view.formFiles).hide();
    }
    if (type == "FILES") {
        $(view.formPictures).hide();
        $(view.formFiles).show();
    }
};


/**
 * Update the form attached files and pictures
 */
ViewAttachPopUp.prototype.update = function () {
    // Define this view
    var view = this;

    // PICTURES FORM
    if (!view.isUploadingPictures && !view.isFormPicturesModified) {
        // Hide the save changes button
        $(view.picturesSubmitBtn).hide();

        // Get the picture ids
        var pictures = view.objectData.pictures != "" ? view.objectData.pictures.split(";") : [];

        // Reset the attached pictures container
        if (pictures.length > 0) {
            $(view.picturesAttachedContainer).empty();
        }
        else {
            $(view.picturesAttachedContainer).html('<p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_PICTURES", "ManagerApp") + '</p>');
        }

        // Update the attached pictures
        $(pictures).each(function (k, v) {
            v = v.split(",");

            var thumb = $('<div class="attachThumb unselectable" pictureId="' + v[0] + '"></div>');
            var img = $('<img class="transitionFast" src="' + view.moduleComponent.modeler.serviceFileGet + "&" + UtilsHttp.encodeParams({
                    'fileId': v[0],
                    'dimensions': '100x100'
                }) + '">');
            var remove = $('<span class="skinIcon attachThumbRemove"></span>');

            $(thumb).append(img, remove);
            $(view.picturesAttachedContainer).append(thumb);

            // Thumb click event
            $(thumb).click(function (e) {
                var pictureId = $(this).attr("pictureId");

                if ($(e.target).hasClass("attachThumbRemove")) {
                    $(view.picturesSubmitBtn).show();
                    view.isFormPicturesModified = true;
                    view.picturesToRemove.push(pictureId);
                    $(this).remove();

                    if ($(view.picturesAttachedContainer).html() == "") {
                        $(view.picturesAttachedContainer).html('<p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_PICTURES", "ManagerApp") + '</p>');
                    }
                }
                else {
                    var fullImg = $('<img src="' + view.moduleComponent.modeler.serviceFileGet + "&" + UtilsHttp.encodeParams({'fileId': pictureId}) + '">');
                    ManagerPopUp.image(fullImg);
                }
            });
        });
    }

    // FILES FORM
    if (!view.isUploadingFiles && !view.isFormFilesModified) {
        // Hide the save changes button
        $(view.filesSubmitBtn).hide();

        // Get the file ids
        var files = view.objectData.files != "" ? view.objectData.files.split(";") : [];

        // Reset the attached files container
        if (files.length > 0) {
            $(view.filesAttachedContainer).empty();
        }
        else {
            $(view.filesAttachedContainer).html('<p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_FILES", "ManagerApp") + '</p>');
        }

        // Update the atached files
        $(files).each(function (k, v) {
            v = v.split(",");

            var lockerClass = v[2] == 1 ? "locked" : "";
            var thumb = $('<div class="attachThumb unselectable" fileId="' + v[0] + '"></div>');
            var icon = $('<div class="transitionFast skinIcon attachThumbIcon"></div>');
            var name = $('<p>' + v[1] + '</p>');
            var locker = $('<span class="skinIcon attachThumbPrivate ' + lockerClass + '"></span>');
            var remove = $('<span class="skinIcon attachThumbRemove"></span>');

            $(thumb).append(icon, name, locker, remove);
            $(view.filesAttachedContainer).append(thumb);

            // Thumb click event
            $(thumb).click(function (e) {
                var fileId = $(this).attr("fileId");

                if ($(e.target).hasClass("attachThumbRemove")) {
                    $(view.filesSubmitBtn).show();
                    view.isFormFilesModified = true;
                    view.filesToRemove.push(fileId);
                    $(this).remove();

                    if ($(view.filesAttachedContainer).html() == "") {
                        $(view.filesAttachedContainer).html('<p class="noFiles">' + ModelApplication.literals.get("ATTACH_NO_ATTACHED_FILES", "ManagerApp") + '</p>');
                    }
                    return;
                }
                if ($(e.target).hasClass("attachThumbPrivate")) {
                    view.isFormFilesModified = true;
                    view.lastLocker = e.target;
                    view.moduleComponent.controller.filePrivateSet(fileId, !$(e.target).hasClass("locked"));
                    return;
                }

                // Generate a validation key for the private files
                $.post(view.moduleComponent.modeler.serviceFilePrivateKeyGenerate, {fileId: fileId}, function (validationKey) {
                    UtilsHttp.goToUrl(view.moduleComponent.modeler.serviceFileGet + "&" + UtilsHttp.encodeParams({
                            'fileId': fileId,
                            'validationKey': validationKey
                        }), true);
                });
            });
        });
    }
};


/**
 * Upload start handler
 *
 * @param formType The form type (formPictures or formFiles)
 *
 */
ViewAttachPopUp.prototype._uploadStartHandler = function (formType) {
    // Define this view
    var view = this;

    // Set uploading files/pictures as true
    if (formType == "formPictures") {
        view.isUploadingPictures = true;
        view.isFormPicturesModified = false;
    }
    if (formType == "formFiles") {
        view.isUploadingFiles = true;
        view.isFormFilesModified = false;
    }

    // Show the processing elements
    view._showOnlyProcessingElements(formType);
};


/**
 * On upload success handler
 *
 * @param formType The form type (formPictures or formFiles)
 */
ViewAttachPopUp.prototype._uploadSuccessHandler = function (formType) {
    // Define this view
    var view = this;

    // Set uploading files/pictures as false
    if (formType == "formPictures") {
        view.isUploadingPictures = false;
    }
    if (formType == "formFiles") {
        view.isUploadingFiles = false;
    }

    // Show the initial elements
    view._showOnlyInitialElements(formType);

    // Get the form element
    formElement = view[formType];

    // Remove the files from the preview container and hide it
    $(formElement).find("div.componentFormFilesPreview").empty().hide();

    // Remove the file inputs on the form
    $(formElement).find("input[type=file]").remove();

    // Remove the requested files / pictures
    view._removeRequest(formType);
};


/**
 * Request files / pictures to be removed
 *
 * @param formType The form type (formPictures or formFiles)
 */
ViewAttachPopUp.prototype._removeRequest = function (formType) {
    // Define this view
    var view = this;

    if (formType == "formPictures") {
        view.moduleComponent.controller.filesRemove(view.picturesToRemove);
        view.picturesToRemove = [];
    }
    if (formType == "formFiles") {
        view.moduleComponent.controller.filesRemove(view.filesToRemove);
        view.filesToRemove = [];
    }
};


/**
 * On remove request success handler
 */
ViewAttachPopUp.prototype._removeRequestSuccessHandler = function () {
    // Define this view
    var view = this;

    // Request data reload
    view._requestReloadData();
};


/**
 * On remove request error handler
 */
ViewAttachPopUp.prototype._removeRequestErrorHandler = function () {
    // Define this view
    var view = this;

    // Show the error notification
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("ATTACH_REQUEST_REMOVE_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    }, function () {
        // Request data reload
        view._requestReloadData();
    });
};


/**
 * Request to reload the object data
 */
ViewAttachPopUp.prototype._requestReloadData = function () {
    // Define this view
    var view = this;

    // Define the attachOrEdit state
    view.moduleComponent.attachOrEdit = "ATTACH_REQUEST";

    // Call the controller to get the object
    if (view.objectKind == "object") {
        view.moduleComponent.controller.objectGet(view.objectData.objectId);
    }

    // Call the controller to get the folder object
    if (view.objectKind == "folder") {
        view.moduleComponent.controller.folderGet(view.objectData.folderId);
    }

    // Increase the reloading state
    view.isReloadingData++;
};


/**
 * On data reload request success
 */
ViewAttachPopUp.prototype._requestReloadDataSuccessHandler = function (objectKind) {
    // Define this view
    var view = this;

    if (view.moduleComponent.attachOrEdit == "ATTACH_REQUEST") {

        // Reload the object data
        if (objectKind == "object") {
            view.objectData = view.moduleComponent.modeler.objectGet;
        }

        if (objectKind == "folder") {
            view.objectData = view.moduleComponent.modeler.folderGet;
        }

        // Update the form with the reloaded database data
        view.update();

        // Decrease the reloading state
        view.isReloadingData--;

        // If the reloading state is 0, remove the attachOrEdit state
        if (view.isReloadingData <= 0) {
            view.isReloadingData = 0;
            view.moduleComponent.attachOrEdit = null;
        }
    }
};


/**
 * On data reload request error
 */
ViewAttachPopUp.prototype._requestReloadDataErrorHandler = function () {
    // Define this view
    var view = this;

    // Show the error notification
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("ATTACH_REQUEST_DATA_ERROR", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });

    // Decrease the reloading state
    view.isReloadingData--;

    // If the reloading state is 0, remove the attachOrEdit state
    if (view.isReloadingData <= 0) {
        view.isReloadingData = 0;
        view.moduleComponent.attachOrEdit = null;
    }
};


/**
 * On upload error handler
 *
 * @param formType The form type (formPictures or formFiles)
 */
ViewAttachPopUp.prototype._uploadErrorHandler = function (formType) {
    // Define this view
    var view = this;

    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("ATTACH_ERROR_MESSAGE", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });

    // Show the initial elements
    view._showOnlyInitialElements(formType);

    // Get the form element
    formElement = view[formType];

    // Remove the files from the preview container and hide it
    $(formElement).find("div.componentFormFilesPreview").empty().hide();

    // Remove the file inputs on the form
    $(formElement).find("input[type=file]").remove();
};


/**
 * On file set private success handler
 */
ViewAttachPopUp.prototype._fileSetPrivateSuccessHandler = function () {
    // Define this view
    var view = this;

    // Toogle the locked class
    if ($(view.lastLocker).hasClass("locked")) {
        $(view.lastLocker).removeClass("locked");
    }
    else {
        $(view.lastLocker).addClass("locked");
    }
};


/**
 * On file set private error handler
 */
ViewAttachPopUp.prototype._fileSetPrivateErrorHandler = function () {
    ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("ATTACH_FILE_SET_PRIVATE_ERROR_MESSAGE", "ManagerApp"), [
        {
            label: ModelApplication.literals.get("ACCEPT", "ManagerApp")
        }
    ], {
        className: "error"
    });
};


/**
 * Show only the processing elements (when the service is uploading the files)
 *
 * @param formType The form type (formPictures or formFiles)
 */
ViewAttachPopUp.prototype._showOnlyProcessingElements = function (formType) {
    // Define this view
    var view = this;

    // Get the form element
    formElement = view[formType];

    // Hide the add button
    $(formElement).find("input.componentFormFileSelector").hide();

    // Hide the attached files container
    $(formElement).find("div.filesAttachedContainer").hide();

    // Disable deleting the pictures from the preview container
    $(formElement).find("span.componentFormPreviewRemove").hide();

    // Hide the submit button
    $(formElement).find("input[type=submit]").hide();

    // Show uploading files message
    $(formElement).find("p.componentFormFileSelectorMessage").show();

    // Show the progress bar
    $(formElement).find("div.componentFormProgressBar").show();
};


/**
 * Show only the initial elements (when the user can select the files to upload)
 *
 * @param formType The form type (formPictures or formFiles)
 */
ViewAttachPopUp.prototype._showOnlyInitialElements = function (formType) {
    // Define this view
    var view = this;

    // Get the form element
    formElement = view[formType];

    // Hide the progress bar
    $(formElement).find("div.componentFormProgressBar").hide();

    // Hide the uploading diles message
    $(formElement).find("p.componentFormFileSelectorMessage").hide();

    // Show the submit button
    $(formElement).find("input[type=submit]").show();

    // Show the attached files container
    $(formElement).find("div.filesAttachedContainer").show();

    // Show the add button
    $(formElement).find("input.componentFormFileSelector").show();
};
