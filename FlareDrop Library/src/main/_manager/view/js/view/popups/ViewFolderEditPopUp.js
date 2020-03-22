/**
 * Folder edit PopUp
 *
 * @param moduleComponent The module component
 * @param folderData The folder data only when editing a folder
 */
function ViewFolderEditPopUp(moduleComponent, folderData) {

    // Declare this view
    var view = this;

    // Define the folder data
    view.folderData = folderData;

    // Save the module component
    view.moduleComponent = moduleComponent;

    // Create the PopUp window
    var dialogTitle = view.folderData !== undefined ? ModelApplication.literals.get("FOLDER_EDIT", "ManagerApp") + " (id " + view.folderData.folderId + ")" : ModelApplication.literals.get("FOLDER_NEW", "ManagerApp");

    view.w = ManagerPopUp.window(dialogTitle, "", {
        width: 500,
        maxHeight: 600
    });

    // Create the form element
    var form = $('<form class="row editPopUp" id="folderEdit"></form>');

    $(view.w).append(form);

    // Define input names and descriptions objects arrays
    view.inputLanId = {}; // Used to store the object's literal id in a hidden inputs of the form
    view.inputName = {};
    view.inputDescription = {};

    // Create language selector and append it to the form
    var literals = [];

    $(ModelApplication.literals.getLanTags()).each(function (k, v) {
        literals.push({
            value: v,
            label: v
        });
    });

    // Create literal selector if it's not one literal
    if (ModelApplication.literals.getLanTags().length > 1) {
        view.literalChooser = new ComponentOptionBar(form, literals, function (v) {
            view.literalSelect(v);
        });
    }

    // Create the necessary literal inputs
    $(ModelApplication.literals.getLanTags()).each(function (k, tag) {

        // Create the lanId hidden inputs for each literal
        view.inputLanId[tag] = $('<input type="hidden">');

        // Create the name inputs for each literal
        view.inputName[tag] = $('<input type="text" maxlength="255" validate="fill" validateErrorMessage="' + ModelApplication.literals.get("FOLDER_NAME_ERROR", "ManagerApp") + ";" + ModelApplication.literals.get("ERROR", "ManagerApp") + '">');

        // Create the description inputs for each literal
        view.inputDescription[tag] = $('<textarea></textarea>');
    });

    // Create folder name and description labels
    var nameLabel = $('<div class="row"><p>' + ModelApplication.literals.get("FOLDER_NAME", "ManagerApp") + "*</p></div>");
    var descriptionLabel = $('<div class="row"><p>' + ModelApplication.literals.get("FOLDER_DESCRIPTION", "ManagerApp") + "</p></div>");

    // Create the visible input
    var visibleLabel = $('<div class="row"><p>' + ModelApplication.literals.get("FOLDER_VISIBLE", "ManagerApp") + "</p></div>");
    var visibleComponent = $('<div class="row"></div>');
    view.visibleComponent = new ComponentSwitch(visibleComponent, false);

    // Create submit button
    var submitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '">');

    // Append name to the form
    $(form).append(nameLabel);

    for (i in view.inputName) {
        $(form).append(view.inputName[i]);
    }

    // Append description to the form
    $(form).append(descriptionLabel);

    for (i in view.inputDescription) {
        $(form).append(view.inputDescription[i]);
    }

    // Append the visible input
    $(form).append(visibleLabel, visibleComponent);

    // Append submit and cancel buttons to the form
    $(form).append(submitBtn);

    // Select the first literal
    if (view.literalChooser !== undefined) {
        view.literalChooser.selectIndex(0);
    }

    // Add the form to the form manager
    ManagerForm.add(form, undefined, undefined, function () {

        // Generate JSON before sending data to the PHP service
        view.moduleComponent.controller.folderSet(view.generateData());
    });

    // If its in a EDIT mode, we have to fill all inputs with the selected folder data
    if (view.folderData !== undefined) {

        if (view.folderData.visible == 1) {
            view.visibleComponent.check();
        }

        for (i in view.inputName) {

            $(view.folderData.literals).each(function (k, folderLan) {

                if (folderLan.tag == i) {
                    $(view.inputLanId[i]).val(folderLan.lanId);
                    $(view.inputName[i]).val(folderLan.name);
                    $(view.inputDescription[i]).val(folderLan.description);
                }
            });
        }
    }
}


/**
 * Select the PopUp literal
 *
 * @param tag The literal to be selected
 */
ViewFolderEditPopUp.prototype.literalSelect = function (tag) {
    // Define this view
    var view = this;

    // Show or hide input names and descriptions
    for (i in view.inputLanId) {
        if (i != tag) {
            $(view.inputName[i]).hide();
            $(view.inputDescription[i]).hide();
        }
        else {
            $(view.inputName[i]).show();
            $(view.inputDescription[i]).show();
        }
    }
};


/**
 * Generate JSON of the filled form data
 *
 * @returns string
 */
ViewFolderEditPopUp.prototype.generateData = function () {

    // Define this view
    var view = this;

    var selectedFolder = view.moduleComponent.modeler.selectedFolder;

    var folderData = {};

    folderData.visible = view.visibleComponent.isOpened() ? 1 : 0;

    // ON EDIT
    if (view.folderData !== undefined) {

        // Set the folder ID
        folderData.folderId = view.folderData.folderId;

        // Set the disk ID
        folderData.diskId = view.folderData.diskId;

        // Set the folder object type
        folderData.objectType = view.folderData.objectType;

        // Set the folder parent
        folderData.parentFolderId = view.folderData.parentFolderId;

        // Set the privileges
        folderData.privilegeId = view.folderData.privilegeId;

        // Set index priority
        folderData.index = view.folderData.index;
    }

    // ON CREATING
    else {
        // Set the folder object type
        folderData.objectType = view.moduleComponent.modeler.name;

        // Set the disk ID
        folderData.diskId = view.moduleComponent.modeler.selectedDisk;

        // Set the folder path
        folderData.parentFolderId = selectedFolder != null ? selectedFolder.folderId : null;
    }

    // Create the literals array
    folderData.literals = [];

    // Fill the literals array
    for (i in view.inputName) {

        var folderLiteral = {};

        folderLiteral.tag = i;
        folderLiteral.lanId = $(view.inputLanId[i]).val();
        folderLiteral.name = $(view.inputName[i]).val();
        folderLiteral.description = $(view.inputDescription[i]).val();
        folderData.literals.push(folderLiteral);
    }

    // Return the folder data as a JSON object
    return UtilsConversion.objectToJson(folderData);
};