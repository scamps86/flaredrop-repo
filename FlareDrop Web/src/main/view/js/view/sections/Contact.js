$(document).ready(function () {
    SystemWeb.initializeSectionJs("contact", function () {
        // Contact form send
        ManagerForm.add($("#contactForm"), function () {
            ManagerPopUp.dialog(successTitle, formSuccessMessage, [
                {label: "ok"}
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(errorTitle, formErrorMessage, [
                {label: "ok"}
            ], {className: "error"});
        });
    });
});