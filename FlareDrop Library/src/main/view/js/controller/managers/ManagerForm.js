/**
 * HTML form elements manager
 *
 */
function ManagerFormClass() {
    this.forms = [];
}


/**
 * Add a form to the manager to allow sending it to the PHP service with one or multiple files, validate its inputs and show the attached files information.<br>
 * <br>
 * The form element must have this required parameters:<br>
 * <br>
 * <b>id:</b> The form ID<br>
 * <b>serviceUrl:</b> The relative PHP service URL. If not defined, The form will be validated but not sent<br>
 * <b>filesQuantity</b> - Validates if the number of added files is lower than the defined (OPTIONAL)
 * <br>
 * The form input elements should have this parameters:<br>
 * <br>
 * <b>name:</b> Defines the name for the value that will be sent by POST to the HTTP service. If it is not defined, this input will be validated but not sent.<br>
 * <b>validateCondition:</b> Define the validation condition if there are more than one validation type. It can be AND or OR.<br>
 * <ul>
 * <li>AND means that all of validations must be ok.</li>
 * <li>OR means that one of each validation must be ok.</li>
 * </ul>
 * <br>
 * <b>validate:</b> Define the validation types separated by ";":<br>
 * <ul>
 * <li>email - Validates an email.</li>
 * <li>phone - Validates a phone number.</li>
 * <li>fill - Validates if the input value is filled.</li>
 * <li>empty - Validates if the input value is empty.</li>
 * <li>integer - Validates an +- integer.</li>
 * <li>numberNatural - Validates a natural number from 0 to infinite.</li>
 * <li>number - Validates an integer or decimal number (1, 1.22, etc..)</li>
 * <li>default - Validates if the input value only has A to Z lowercase and uppercase and numbers.</li>
 * <li>dni - Validates a DNI.</li>
 * <li>dateDMY - Validates a date like dd/mm/aaaa from year 1900 to 3000.</li>
 * <li>password - Validates a password. At least 6 characters, one number, one lowercase and one uppercase letter.</li>
 * <li>checked - Validates if a check box is checked (for check boxes only).</li>
 * <li>minCharacters - Validates if the input value is at least of minimal characters defined in another property: <i>validateMinCharacters="10".</i></li>
 * <li>fileSize - Validates if each file size is less than specified in KB: <i>validateFileSize="1024".</i></li>
 * <li>fileType - Validates if each file content type matches the defined ones in another property separated by a semicolon: <i>validateFileType="image/jpeg;image/png".</i></li>
 * <li>repeat - Validates if all input values matches in the same group defined in another property in each ones: <i>validateRepeatGroup="group1".</i></li>
 * </ul>
 * <br>
 * <b>validateErrorMessage:</b> Define the PopUp error message and title separated by a semicolon when an input validation fails. <br>
 * <br>
 * <b>Input class states: </b>(note that these class states will be applied only on the form elements that matches the corresponding input element name with its class name):<br>
 * <ul>
 * <li>validateError - When the input validation fails</li>
 * <li>validateSuccess - When the input validation success</li>
 * </ul>
 *
 * This method also allows a progress bar live status. Simply add a div with the class "componentFormProgressBar" inside the form element. Inside it, it will create an empty DIV that will be the completed bar and a P containing the percent
 * value.<br>
 * <br>
 * This method also allows the file information. Simply add a div element with the class "componentFormFilesPreview" inside the form element. Inside it, it will create the a P with its SPAN for each file information (file name, size
 * in MB and remove. "componentFormPreviewName", "componentFormPreviewSize", "componentFormPreviewRemove"). <br>
 * <br>
 * This method allows a simple input button to add files to allow the CSS customization. Simply must define an button input with the class "componentFormFileSelector". All validation properties will be applied.<br>
 * <br>
 * This method also can
 *
 * @param formElement The form element. Be sure that te form has the id and serviceURL properties defined.
 * @param successHandler A function called when the form success. (When the AJAX service returns an empty string)
 * @param errorHandler A function called when the form has an error uploading the data. (When the AJAX service returns something)
 * @param processHandler A function called when the form is validated and is starting to send the data to the service. It can be used to generate some specific data to be sent. The first parameter is the current form element
 * @param cancelHandler A function called when the user cancels the form upload process.
 * @param fileSelectHandler A function called when a file is selected in an input file type.
 */
ManagerFormClass.prototype.add = function (formElement, successHandler, errorHandler, processHandler, cancelHandler, fileSelectHandler) {
    // Get the form id
    var formId = $(formElement).attr("id");

    // Create the form object where all public elements will be stored
    var formObject = {};

    // Save the object to the manager array
    this.forms[formId] = formObject;

    // Define this form element to the object
    formObject['formElement'] = formElement;

    // READ THE FORM PROGRESS BAR
    var progressBar = $(formElement).find("div.componentFormProgressBar");

    if (progressBar.length > 0) {
        $(progressBar).html('<div class="transitionSlow"></div><p>0%</p></div>');
    }

    // READ THE FORM FILE PREVIEW CONTAINER
    var preview = $(formElement).find("div.componentFormFilesPreview");
    $(preview).hide();

    // FORM FILES SELECT & PREVIEW INFO
    $(formElement).find("input.componentFormFileSelector").click(function () {
        // Validate the form max files allowed
        if ($(formElement).attr("filesQuantity")) {
            var fileInputsCount = 0;
            $(formElement).find("input[type=file]").each(function (k, v) {
                if ($(v).val() != "") {
                    fileInputsCount++;
                }
            });
            if (fileInputsCount >= $(formElement).attr("filesQuantity")) {
                return;
            }
        }

        // Create and launch a input file
        var inputElement = $('<input type="file" class="componentFormVirtualInput">');

        // Generate an id/name for the input
        var inputIndex = 0;

        while ($("#componentFormVirtualInput" + inputIndex).length == 1) {
            inputIndex++;
        }

        var inputId = "componentFormVirtualInput" + inputIndex;

        // Add the input attributes
        $(inputElement).attr("id", inputId);
        $(inputElement).attr("name", inputId);
        $(inputElement).attr("validate", $(this).attr("validate"));
        $(inputElement).attr("validateCondition", $(this).attr("validateCondition"));
        $(inputElement).attr("validateFileSize", $(this).attr("validateFileSize"));
        $(inputElement).attr("validateFileType", $(this).attr("validateFileType"));
        $(inputElement).attr("validateRequired", $(this).attr("validateRequired"));
        $(inputElement).attr("validateErrorMessage", $(this).attr("validateErrorMessage"));

        // Hide it
        $(inputElement).hide();

        // Add the input to the form
        $(formElement).append(inputElement);

        // Trigger the click event
        $(inputElement).trigger("click");

        // Detect the virtual input change element to generate the preview
        $(inputElement).change(function () {
            // Call the file select event handler if defined
            if (fileSelectHandler !== undefined) {
                fileSelectHandler.apply();
            }

            // Fill the preview if it's defined
            if (preview.length > 0) {
                // Show the preview container
                $(preview).show();

                // Scan the selected files and add them to the preview
                for (var i = 0; i < this.files.length; i++) {
                    var fileInfo = $('<p><span class="fontBold componentFormPreviewName">' + this.files[i].name + '</span><span class="componentFormPreviewSize">' + UtilsUnits.bytesToMegabytes(this.files[i].size) + 'MB<span></p>');
                    var removeFile = $('<span inputRef="' + inputId + '" class="componentFormPreviewRemove"></span>');

                    $(fileInfo).append(removeFile);
                    $(preview).append(fileInfo);

                    $(removeFile).click(function () {
                        // Remove the file input
                        $("#" + $(this).attr("inputRef")).remove();

                        // Remove this file preview
                        $(this).parent().remove();

                        // Hide the preview container if there is no info
                        if ($(preview).html() == "") {
                            $(preview).hide();
                        }
                    });
                }
            }
        });
    });

    // FORM SWITCH COMPONENTS GENERATION
    $(formElement).find("div.componentFormSwitchComponentContainer").each(function (k, v) {
        var sw = new ComponentSwitch(v, false, function () {
            $(v).next("input").val(sw.isOpened() ? 1 : -1);
        });
        if ($(this).attr("opened") == 1) {
            sw.check();
        }
    });

    // FORM OPTION BAR COMPONENTS GENERATION
    $(formElement).find("div.componentFormOptionBarComponentContainer").each(function (k, v) {
        var data = UtilsConversion.jsonToObject(UtilsConversion.base64Decode($(v).attr("data")));
        var ob = new ComponentOptionBar(v, data, function () {
            $(v).next("input").val(ob.getSelectedValue());
        });
        ob.selectIndex($(v).attr("selectedIndex"));
    });

    // FORM DATEPICKER COMPONENTS GENERATION
    $(formElement).find("input.componentFormDatePickerComponentBaseInput").each(function (k, v) {
        var options = UtilsConversion.jsonToObject(UtilsConversion.base64Decode($(v).attr("options")));
        var literals = UtilsConversion.jsonToObject(UtilsConversion.base64Decode($(v).attr("literals")));
        new ComponentDatePicker(v, options, literals);
    });

    // FORM SUBMIT
    $(formElement).submit(function () {
        // Get the form id
        var form = this;

        // Remove the empty virtual file inputs
        $(form).find("input:file").each(function (k, v) {
            if ($(v).hasClass("componentFormVirtualInput") && $(v).val() == "") {
                $(v).remove();
            }
        });

        // Get the form inputs
        var inputs = $(form).find("input, textarea, select");

        // Unfocus all inputs
        $(inputs).blur();

        var formValidationOk = true;
        var validationRepeatElements = {};

        for (var i = 0; i < inputs.length; i++) {
            // Validate the form data
            var validateErrorMessage = $(inputs[i]).attr("validateErrorMessage");

            // Remove inputs validate classes
            $(inputs[i]).removeClass("validateError validateSuccess");

            var validateOk = $(inputs[i]).hasClass("componentFormFileSelector") ? true : validateInput(inputs[i]);

            // On error / success
            if (!validateOk) {
                $(inputs[i]).addClass("validateError");

                if (validateErrorMessage !== undefined && validateErrorMessage !== "") {
                    // Concatenate the ; if it doesn't exist
                    validateErrorMessage = validateErrorMessage.indexOf(";") == -1 ? validateErrorMessage + ";" : validateErrorMessage;

                    validateErrorMessage = validateErrorMessage.split(";");
                    ManagerPopUp.dialog(validateErrorMessage[1], validateErrorMessage[0], [
                        {
                            "label": "Ok"
                        }
                    ], {
                        "className": "error"
                    });

                    // Prevent showing more error pop ups
                    return false;
                }
                formValidationOk = false;
            }
            else {
                $(inputs[i]).addClass("validateSuccess");
            }
        }

        // If the form validation fails, stop the mail submitting
        if (!formValidationOk) {
            return false;
        }

        // Call the process handler only if form validation success
        if (processHandler !== undefined) {
            processHandler.apply(null, [form]);
        }

        // Get the form data
        var fd = new FormData(form);

        // Create the XMLHttpRequest object and save it to the form object to allow its access
        formObject['xhr'] = new XMLHttpRequest();

        // Disable the form inputs and get the form data
        for (i = 0; i < inputs.length; i++) {
            $(inputs[i]).attr("disabled", true);
        }

        /* Form uploading process */
        formObject['xhr'].upload.addEventListener("progress", xhrProgress, false);


        // On form succes
        formObject['xhr'].addEventListener("load", xhrLoad, false);


        // On form error
        formObject['xhr'].addEventListener("error", xhrError, false);


        // On form abort
        formObject['xhr'].addEventListener("abort", xhrAbort, false);

        function xhrProgress(e) {
            if (e.lengthComputable && progressBar.length > 0) {
                var percentComplete = Math.round(e.loaded * 100 / e.total).toString() + "%";
                $("#" + formId + " .componentFormProgressBar div").width(percentComplete);
                $("#" + formId + " .componentFormProgressBar p").html(percentComplete);
            }
        }

        function xhrLoad(e) {
            formProcessFinish();

            if (e.target.responseText == "") {
                // Reset the form
                $(form)[0].reset();

                if (successHandler !== undefined) {
                    successHandler.apply();
                }
            }
            else {
                if (errorHandler !== undefined) {
                    errorHandler.apply(null, [e]);
                }
            }
        }

        function xhrError(e) {
            formProcessFinish();

            if (errorHandler !== undefined) {
                errorHandler.apply(null, [e]);
            }
        }

        function xhrAbort() {
            formProcessFinish();

            if (cancelHandler !== undefined) {
                cancelHandler.apply();
            }
        }


        // Function to do the input validations
        function validateInput(input) {

            var validate = $(input).attr("validate");

            if (validate !== undefined && validate != "") {
                validate = validate.split(";");
                var condition = $(input).attr("validateCondition") == undefined ? "AND" : $(input).attr("validateCondition");
                var value = "";
                var fileSize = 0;
                var fileType = "";
                var validateResults = [];

                if ($(input).attr("type") == "checkbox") {
                    value = $(input).is(":checked");
                }
                else {
                    value = $(input).val();
                }

                if ($(input).attr("type") == "file") {
                    for (f = 0; f < input.files.length; f++) {
                        fileSize += parseInt(input.files[f].size);
                        fileType += input.files[f].type + ";";
                    }

                    if (fileType.length > 0) {
                        fileType = fileType.substring(0, fileType.length - 1);
                        fileType = fileType.split(";");
                    }
                }

                // Do the validations
                for (v = 0; v < validate.length; v++) {
                    var isOk = false;

                    isOk = validate[v] == "email" ? UtilsValidation.isEmail(value) : isOk;
                    isOk = validate[v] == "phone" ? UtilsValidation.isPhone(value) : isOk;
                    isOk = validate[v] == "fill" ? UtilsValidation.isFilled(value) : isOk;
                    isOk = validate[v] == "empty" ? value == "" : isOk;
                    isOk = validate[v] == "integer" ? UtilsValidation.isInteger(value) : isOk;
                    isOk = validate[v] == "numberNatural" ? UtilsValidation.isNumberNatural(value) : isOk;
                    isOk = validate[v] == "number" ? UtilsValidation.isNumber(value) : isOk;
                    isOk = validate[v] == "default" ? UtilsValidation.isDefault(value) : isOk;
                    isOk = validate[v] == "dni" ? UtilsValidation.isDni(value) : isOk;
                    isOk = validate[v] == "dateDMY" ? UtilsValidation.isDateDMY(value) : isOk;
                    isOk = validate[v] == "password" ? UtilsValidation.isPassword(value) : isOk;
                    isOk = validate[v] == "checked" ? value == 1 : isOk;
                    isOk = validate[v] == "minCharacters" ? value.length >= parseInt($(input).attr("validateMinCharacters")) : isOk;
                    isOk = validate[v] == "fileSize" ? fileSize <= UtilsUnits.kilobytesToBytes($(input).attr("validateFileSize")) : isOk;

                    if (validate[v] == "fileType") {

                        var types = $(inputs[i]).attr("validateFileType").split(";");

                        for (var t = 0; t < fileType.length; t++) {

                            var typesOk = false;

                            for (var f = 0; f < types.length; f++) {
                                if (types[f] == fileType[t]) {
                                    typesOk = true;
                                    break;
                                }
                            }
                            isOk = typesOk;

                            if (!typesOk) {
                                break;
                            }
                        }
                    }


                    if (validate[v] == "repeat") {
                        var group = $(inputs[i]).attr("validateRepeatGroup");

                        if (validationRepeatElements[group] === undefined) {
                            validationRepeatElements[group] = [];
                        }

                        validationRepeatElements[group].push(value);
                        var repeatValidationOk = true;

                        for (var g = 0; g < validationRepeatElements[group].length; g++) {
                            if (validationRepeatElements[group][g] != value) {
                                repeatValidationOk = false;
                                break;
                            }
                        }
                        isOk = repeatValidationOk;
                    }

                    // Add the validation result to the array
                    validateResults.push(isOk);
                }

                // Verify the validate condition AND or OR
                for (var v = 0; v < validateResults.length; v++) {

                    if (condition == "AND") {
                        if (!validateResults[v]) {
                            return false;
                        }
                    }

                    if (condition == "OR") {
                        if (validateResults[v]) {
                            return true;
                        }
                    }
                }

                // If all validations are false in OR condition
                if (condition == "OR") {
                    return false;
                }
            }
            return true;
        }


        // Function to remove the current form processing class and enable all of its inputs
        function formProcessFinish() {
            formObject['xhr'].removeEventListener("load", xhrLoad, false);
            formObject['xhr'].removeEventListener("error", xhrError, false);
            formObject['xhr'].upload.removeEventListener("progress", xhrProgress, false);
            formObject['xhr'].removeEventListener("abort", xhrAbort, false);

            // Enable the form inputs
            for (var i = 0; i < inputs.length; i++) {
                $(inputs[i]).attr("disabled", false);
            }

            // Reset the progress bar
            if (progressBar.length > 0) {
                $("#" + formId + " .componentFormProgressBar div").width(0);
                $("#" + formId + " .componentFormProgressBar p").html("0%");
            }
        }

        /* Do the POST call to the service only if defined */
        if ($(form).attr("serviceUrl") !== undefined && $(form).attr("serviceUrl") != "") {
            formObject['xhr'].open("POST", $(form).attr("serviceUrl"));
            formObject['xhr'].setRequestHeader("Cache-Control", "no-cache");
            formObject['xhr'].send(fd);
        }
        else {
            formProcessFinish();
        }

        return false;
    });
};


/**
 * Abort the form uploading process
 *
 * @param formElement The form element
 */
ManagerFormClass.prototype.abort = function (formElement) {
    var formId = $(formElement).attr("id");

    if (this.forms[formId]['xhr'] !== undefined) {
        this.forms[formId]['xhr'].abort();
    }
};