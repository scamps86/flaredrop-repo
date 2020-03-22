$(document).ready(function () {
    SystemWeb.initializeSectionJs("contact", function () {
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

        // Google maps
        UtilsGoogleMaps.generateMap($("#gm"), 41.566495, 2.0033669, 16);
    });
});