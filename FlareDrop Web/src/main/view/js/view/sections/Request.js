$(document).ready(function () {
    SystemWeb.initializeSectionJs("request", function () {
        // Request form send
        ManagerForm.add($("#requestForm"), function () {
            ManagerPopUp.dialog(successTitle, formSuccessMessage, [
                {label: "ok"}
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(errorTitle, formErrorMessage, [
                {label: "ok"}
            ], {className: "error"});
        });

        // Automatically hide web inputs if the URL parameter is selected as disk-hosting
        if (product == "domain-hosting") {
            formToggleWebInputs(false);
        }

        // Form web type toogle
        $("#frmWebType ul.componentOptionBar li").click(function () {
            if ($("#frmWebType").find("input[type=hidden]").val() == "domain-hosting") {
                formToggleWebInputs(false);
            }
            else {
                formToggleWebInputs(true);
            }
        });
    });
});


/**
 * Toggle the form inputs
 *
 * @param show If the web inputs are visible or not
 */
function formToggleWebInputs(show) {
    var inputs = $("#frmWebDesign, #frmWebMaterial, #frmWebLanguages, #frmWebSections, #frmWebSectionsDynamic, #frmWebOthers");

    if (show) {
        $(inputs).show();
        $(inputs).find("input[type=text], textarea").val("");
    }
    else {
        $(inputs).hide();
        $(inputs).find("input[type=text], textarea").val("x");
    }
}