$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {

        // Show picture popup
        $("#homeList img").click(function () {
            var img = $("<img />");
            $(img).attr("src", $(this).attr("src"));
            ManagerPopUp.image(img);
        });

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
        UtilsGoogleMaps.generateMap($("#gm"), 41.59580, 2.08687, 16);

    });
});