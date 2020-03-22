$(document).ready(function () {
    SystemWeb.initializeSectionJs("help", function () {
        // Slider
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "goDown",
            stopOnHover: true,
            navigation: false,
            pagination: false
        });

        // Signin form send
        ManagerForm.add($("#signInForm"), function () {
            ManagerPopUp.dialog(FRM_SIGN_IN_TITLE, FRM_SIGN_IN_SUCCESS, [
                {
                    label: DIALOG_ACCEPT, action: function () {
                    UtilsHttp.goToUrl(SECTION_USER_BUY_BANS_URL);
                }
                }
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(DIALOG_ERROR, FRM_SIGN_IN_ERROR, [
                {label: DIALOG_ACCEPT}
            ], {className: "error"});
        });
    });

    // Show user conditions
    $("#frmShowUserConditions").click(function () {
        showUserConditionsPopUp();
    });
});