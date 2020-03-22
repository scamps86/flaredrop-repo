$(document).ready(function () {
    SystemWeb.initializeSectionJs("contacte", function () {

        // Contact form send
        ManagerForm.add($("#contactForm"), function () {
            ManagerPopUp.dialog(dialogSuccess, formSuccessMessage, [
                {label: "ok"}
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(dialogError, formErrorMessage, [
                {label: "ok"}
            ], {className: "error"});
        });

        // Initialize Google maps
        UtilsGoogleMaps.generateMap($("#gm"), 41.61636, 2.08629, 16);
    });
});