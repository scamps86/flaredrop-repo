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
    });
});