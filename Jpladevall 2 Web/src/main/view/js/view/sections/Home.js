$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {

        // Show user validation success
        if (USER_VALIDATION_SUCCESS === 1) {
            ManagerPopUp.dialog(DIALOG_SUCCESS, USER_VALIDATION_SUCCESS_MESSAGE, [
                {
                    label: DIALOG_ACCEPT
                }
            ], {className: "success"});
        }

        // Listen register button to show or hide join form
        var joinForm = $('#userJoinForm'),
            registerContent = $('#registerContent');

        $("#userJoinFormSubmit").click(function () {
            $(joinForm).show();
            $(this).hide();
            $(registerContent).hide();
        });

        // Join form send
        ManagerForm.add(joinForm, function () {
            ManagerPopUp.dialog(DIALOG_SUCCESS, FRM_JOIN_SUCCESS, [
                {
                    label: DIALOG_ACCEPT,
                    action: function () {
                        UtilsHttp.refresh();
                    }
                }
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(DIALOG_ERROR, FRM_JOIN_ERROR, [
                {label: DIALOG_ACCEPT}
            ], {className: "error"});
        });


        // Login form send
        ManagerForm.add($('#userLoginForm'), function () {
            UtilsHttp.goToUrl(SECTION_PRIVATE_HOME);
        }, function () {
            ManagerPopUp.dialog(DIALOG_ERROR, FRM_LOGIN_ERROR, [
                {label: DIALOG_ACCEPT}
            ], {className: "error"});
        });

    });
});