/**
 * Object edit PopUp
 *
 * @param moduleComponent The module component
 * @param objectData The object data only when editing an object
 */
function ViewObjectEditPopUp(moduleComponent, objectData) {

    // Declare this view
    var view = this;

    // Define the object data
    view.objectData = objectData;

    // Define is edit mode
    view.isEditMode = objectData !== undefined;

    // Save the module component
    view.moduleComponent = moduleComponent;

    // Define object property configurations
    view.properties = view.moduleComponent.modeler.configuration.properties;

    // Create the PopUp window
    var dialogTitle = view.isEditMode ? ModelApplication.literals.get("OBJECT_EDIT", "ManagerApp") + " (id " + objectData[view.moduleComponent.modeler.primaryKey] + ")" : ModelApplication.literals.get("OBJECT_NEW", "ManagerApp");

    view.w = ManagerPopUp.window(dialogTitle, "", {
        width: 500,
        maxHeight: 600
    });


    // Create the form element
    var form = $('<form class="row editPopUp" id="objectEdit"></form>');

    $(view.w).append(form);

    // Define the literal ids object
    view.lanIds = {}; // Object that contains all literals with its ids if it's an object modification: ex: view.lanIds['ca_ES'] = 12

    // Define the literal input object
    view.literalInputs = {}; // Object that contains all literal inputs and p separated by it's literal tag: ex: view.literalInputs['ca_ES']['p_property']

    // Define the non literal input object
    view.nonLiteralInputs = {}; // Object that contains all non literal inputs and p: ex: view.nonLiteralInputs['p_property']

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

    // Define variable to store the input type in the inputs generation
    var inputType = "";

    // Generate the localized inputs
    $(ModelApplication.literals.getLanTags()).each(function (k, tag) {

        // Scan all object properties to create it's own inputs
        $(view.properties).each(function (kk, p) {
            if (p.localized == "1") {

                // Generate a place for this input
                if (view.literalInputs[tag] === undefined) {
                    view.literalInputs[tag] = {};
                }

                // Create P element
                view.literalInputs[tag]["p_" + p.property] = view._generatePropertyFormPElement(p);

                // Create input element
                switch (p.type) {
                    case "check" :
                        inputType = "check";
                        break;
                    case "date" :
                        inputType = "date";
                        break;
                    default:
                        inputType = "input";
                        break;
                }

                view.literalInputs[tag][inputType + "_" + p.property] = view._generatePropertyFormInputElement(p);

                // Fill the value if it's in EDIT mode
                if (view.isEditMode) {
                    // Scan the literals array to get the value for the input
                    $(view.objectData.literals).each(function (k, v) {
                        if (v.tag == tag) {
                            // If it's an object edition, fill the literal ids to the literal ids object if it's not defined
                            if (view.lanIds[tag] === undefined) {
                                view.lanIds[tag] = v.objectLanId;
                            }

                            // Extract the custom language properties
                            var lanProperties = UtilsConversion.jsonToObject(v.properties);

                            // Add the localized property value to its input
                            if (p.type == "text" || p.type == "textarea") {
                                $(view.literalInputs[tag]["input_" + p.property]).val(lanProperties[p.property]);
                            }
                            else if (p.type == "check") {
                                if (lanProperties[p.property] == 1) {
                                    view.literalInputs[tag]["check_" + p.property].check();
                                }
                                else {
                                    view.literalInputs[tag]["check_" + p.property].uncheck();
                                }
                            }
                            else if (p.type == "date") {
                                $(view.literalInputs[tag]["date_" + p.property]).val(lanProperties[p.property]);
                            }
                        }
                    });
                }
            }
        });
    });

    // Generate non localized inputs
    $(view.properties).each(function (k, p) {

        if (p.localized == "0") {

            // Create P element
            view.nonLiteralInputs["p_" + p.property] = view._generatePropertyFormPElement(p);

            // Create input element
            switch (p.type) {
                case "check" :
                    inputType = "check";
                    break;
                case "date" :
                    inputType = "date";
                    break;
                default:
                    inputType = "input";
                    break;
            }

            view.nonLiteralInputs[inputType + "_" + p.property] = view._generatePropertyFormInputElement(p);

            // Fill the value if it's in EDIT mode
            if (view.isEditMode) {
                // Extract the custom language properties
                var properties = view.objectData.properties === undefined ? null : UtilsConversion.jsonToObject(view.objectData.properties);

                if (p.type == "text" || p.type == "textarea") {
                    if (properties != null) {
                        if (properties[p.property] !== undefined) {
                            $(view.nonLiteralInputs["input_" + p.property]).val(properties[p.property]);
                        }
                    }
                    else if (view.objectData[p.property] !== undefined) {
                        $(view.nonLiteralInputs["input_" + p.property]).val(view.objectData[p.property]);
                    }
                }
                else if (p.type == "check") {
                    var check = view.objectData[p.property] === undefined ? properties[p.property] : view.objectData[p.property];
                    if (check == 1) {
                        view.nonLiteralInputs["check_" + p.property].check();
                    }
                    else {
                        view.nonLiteralInputs["check_" + p.property].uncheck();
                    }
                }
                else if (p.type == "date") {
                    if (properties != null) {
                        if (properties[p.property] !== undefined) {
                            $(view.nonLiteralInputs["date_" + p.property]).val(properties[p.property]);
                        }
                    }
                }
            }
        }
    });

    // Create submit button
    var submitBtn = $('<input type="submit" value="' + ModelApplication.literals.get("SAVE", "ManagerApp") + '">');

    // Append the literal inputs to the form
    var i, l, j;

    for (l in view.literalInputs) {
        for (i in view.literalInputs[l]) {
            $(view.properties).each(function (k, p) {
                j = i.split("_");
                if (p.property == j[1]) {
                    if (j[0] == "check") {
                        $(form).append(view.literalInputs[l][i].parent);
                    }
                    else {
                        $(form).append(view.literalInputs[l][i]);
                    }
                }
            });
        }
    }

    // Append the non literal inputs to the form
    for (i in view.nonLiteralInputs) {
        $(view.properties).each(function (k, p) {
            j = i.split("_");
            if (p.property == j[1]) {
                if (j[0] == "check") {
                    $(form).append(view.nonLiteralInputs[i].parent);
                }
                else {
                    $(form).append(view.nonLiteralInputs[i]);
                }
            }
        });
    }

    // Append also the necessary inputs to the form
    $(form).append(submitBtn);

    // Select the first literal
    if (view.literalChooser !== undefined) {
        view.literalChooser.selectIndex(0);
    }

    // Add the form to the form manager
    ManagerForm.add(form, undefined, undefined, function () {

        // Generate JSON before sending data to the PHP service
        view.moduleComponent.controller.objectSet(view.generateData());
    });
}


/**
 * Select the PopUp literal
 *
 * @param literal The literal to be selected
 */
ViewObjectEditPopUp.prototype.literalSelect = function (literal) {

    // Define this view
    var view = this;

    // Show or hide input names and descriptions
    $(ModelApplication.literals.getLanTags()).each(function (n, lan) {
        if (lan != literal) {
            for (i in view.literalInputs[lan]) {
                $(view.literalInputs[lan][i]).hide();
            }
        }
        else {
            for (i in view.literalInputs[lan]) {
                $(view.literalInputs[lan][i]).show();
            }
        }
    });
};


/**
 * Know if the object to be edited / created has at least one localized property
 *
 * @returns {Boolean}
 */
ViewObjectEditPopUp.prototype.hasLocalizedProperties = function () {

    // Define this view
    var view = this;

    var result = false;

    $(view.properties).each(function (k, p) {
        if (p.localized == "1") {
            result = true;
        }
    });

    return result;
};


/**
 * Generate JSON data and save it to the folderData input before be sent to the folder set service
 */
ViewObjectEditPopUp.prototype.generateData = function () {

    // Define this view
    var view = this;

    var objectData = view.objectData;

    // ON CREATING
    if (objectData === undefined) {
        objectData = {};

        // Set the folder id only on creating it
        if (!view.isEditMode) {
            objectData.folderIds = view.moduleComponent.modeler.selectedFolder.folderId;
        }
    }

    var tp = []; // Array: 0 = element tag, 1 = input property
    var base64Encode = false; // Used to know if the property value must be base64 encoded before sending to the service

    // Set the non literal properties
    var properties = {};

    for (n in view.nonLiteralInputs) {
        tp = n.split("_");

        // For users, save the properties, and for objects encode it to a json string
        if (tp[0] == "input" || tp[0] == "date") {
            base64Encode = $(view.nonLiteralInputs[n]).attr("base64Encode") == 1;
            if (view.moduleComponent.modeler.name == "user") {
                objectData[tp[1]] = base64Encode ? UtilsConversion.base64Encode($(view.nonLiteralInputs[n]).val()) : $(view.nonLiteralInputs[n]).val();
            }
            else {
                properties[tp[1]] = base64Encode ? UtilsConversion.base64Encode($(view.nonLiteralInputs[n]).val()) : $(view.nonLiteralInputs[n]).val();
            }
        }
        else if (tp[0] == "check") {
            if (view.moduleComponent.modeler.name == "user") {
                objectData[tp[1]] = view.nonLiteralInputs[n].isOpened() ? 1 : 0;
            }
            else {
                properties[tp[1]] = view.nonLiteralInputs[n].isOpened() ? "1" : "0";
            }
        }
    }

    // Save the object properties as a json string
    if (view.moduleComponent.modeler.name != "user") {
        objectData.properties = UtilsConversion.objectToJson(properties);
    }

    // Create the literals array only if it's a object has localized properties and it's not an user
    if (view.hasLocalizedProperties() && view.moduleComponent.modeler.name != "user") {
        objectData.literals = [];

        // Fill the literals array
        $(ModelApplication.literals.getLanTags()).each(function (k, tag) {
            // Create the object literal
            var objectLan = {};
            objectLan.tag = tag;
            objectLan.objectLanId = view.lanIds[tag];

            var lanProperties = {};

            for (n in view.literalInputs[tag]) {
                tp = n.split("_");

                if (tp[0] == "input" || tp[0] == "date") {
                    base64Encode = $(view.literalInputs[tag][n]).attr("base64Encode") == 1;
                    lanProperties[tp[1]] = base64Encode ? UtilsConversion.base64Encode($(view.literalInputs[tag][n]).val()) : $(view.literalInputs[tag][n]).val();
                }
                if (tp[0] == "check") {
                    lanProperties[tp[1]] = view.literalInputs[tag][n].isOpened() ? "1" : "0";
                }
            }

            // Generate properties json
            objectLan.properties = UtilsConversion.objectToJson(lanProperties);

            // Attach the object literal to the literals array on the main object
            objectData.literals.push(objectLan);
        });
    }

    // Return the folder data as a JSON object
    return UtilsConversion.objectToJson(objectData);
};


/**
 * Generate the P element for the edit form from a property
 *
 * @param p The property
 *
 * @returns Element
 */
ViewObjectEditPopUp.prototype._generatePropertyFormPElement = function (p) {
    // Define this view
    var view = this;

    return $('<div class="row"><p>' + ModelApplication.literals.get(p.literalKey, view.moduleComponent.modeler.configuration.objects.bundle) + (p.validate == "" || p.validate.indexOf("empty") != -1 ? "" : "*") + "</p></div>");
};


/**
 * Generate the input element for the edit form from a property
 *
 * @param p The property
 */
ViewObjectEditPopUp.prototype._generatePropertyFormInputElement = function (p) {
    // Define this viewu
    var view = this;

    var element = null;

    if (p.type == "text" || p.type == "password") {
        element = $('<input type="' + p.type + '">');
    }

    if (p.type == "textarea") {
        element = $("<textarea></textarea>");
    }

    if (p.type == "date") {
        element = $('<input type="text">');

        new ComponentDatePicker(element, undefined, {
            months: {
                JANUARY: ModelApplication.literals.get("MONTH_JANUARY", "ManagerApp"),
                FEBRUARY: ModelApplication.literals.get("MONTH_FEBRUARY", "ManagerApp"),
                MARCH: ModelApplication.literals.get("MONTH_MARCH", "ManagerApp"),
                APRIL: ModelApplication.literals.get("MONTH_APRIL", "ManagerApp"),
                MAY: ModelApplication.literals.get("MONTH_MAY", "ManagerApp"),
                JUNE: ModelApplication.literals.get("MONTH_JUNE", "ManagerApp"),
                JULY: ModelApplication.literals.get("MONTH_JULY", "ManagerApp"),
                AUGUST: ModelApplication.literals.get("MONTH_AUGUST", "ManagerApp"),
                SEPTEMBER: ModelApplication.literals.get("MONTH_SEPTEMBER", "ManagerApp"),
                OCTOBER: ModelApplication.literals.get("MONTH_OCTOBER", "ManagerApp"),
                NOVEMBER: ModelApplication.literals.get("MONTH_NOVEMBER", "ManagerApp"),
                DECEMBER: ModelApplication.literals.get("MONTH_DECEMBER", "ManagerApp")
            },
            days: {
                MONDAY: ModelApplication.literals.get("DAY_T_MONDAY", "ManagerApp"),
                TUESDAY: ModelApplication.literals.get("DAY_T_TUESDAY", "ManagerApp"),
                WEDNESDAY: ModelApplication.literals.get("DAY_T_WEDNESDAY", "ManagerApp"),
                THURSDAY: ModelApplication.literals.get("DAY_T_THURSDAY", "ManagerApp"),
                FRIDAY: ModelApplication.literals.get("DAY_T_FRIDAY", "ManagerApp"),
                SATURDAY: ModelApplication.literals.get("DAY_T_SATURDAY", "ManagerApp"),
                SUNDAY: ModelApplication.literals.get("DAY_T_SUNDAY", "ManagerApp")
            },
            hour: ModelApplication.literals.get("DATEPICKER_HOUR", "ManagerApp"),
            minute: ModelApplication.literals.get("DATEPICKER_MINUTE", "ManagerApp"),
            second: ModelApplication.literals.get("DATEPICKER_SECOND", "ManagerApp"),
            select: ModelApplication.literals.get("DATEPICKER_SELECT", "ManagerApp"),
            mainTitle: ModelApplication.literals.get("DATEPICKER_MAINTITLE", "ManagerApp")
        });
    }

    var attr = {
        "base64Encode": p.base64Encode
    };

    if (p.validate != "") {
        attr.validate = p.validate;
        attr.validateCondition = p.validateCondition;
        attr.validateErrorMessage = ModelApplication.literals.get(p.validateErrorLiteralKey, view.moduleComponent.modeler.configuration.objects.bundle) + ";" + ModelApplication.literals.get("ERROR", "ManagerApp");
    }

    if (element != null) {
        $(element).attr(attr);
        $(element).val(p.defaultValue);
    }

    if (p.type == "check") {
        element = new ComponentSwitch($('<div class="editFormCheckContainer"></div>'), false);

        if (p.defaultValue == 1) {
            element.check();
        }
        else {
            element.uncheck();
        }
    }

    return element;
};