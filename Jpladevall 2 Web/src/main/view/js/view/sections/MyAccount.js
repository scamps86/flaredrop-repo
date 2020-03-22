$(document).ready(function () {
    SystemWeb.initializeSectionJs("myAccount", function () {

        // Unregister account button click
        $("#userUnregisterBtn").click(function () {
            ManagerPopUp.dialog(DIALOG_ALERT, USER_UNREGISTER_SURE, [{
                label: DIALOG_ACCEPT, action: function () {
                    calcelAccount();
                }
            }, {label: DIALOG_CANCEL}], {className: "warning"});

        });

        // Update form send
        ManagerForm.add($("#userModifyForm"), function () {
            ManagerPopUp.dialog(DIALOG_SUCCESS, FRM_USER_MODIFY_SUCCESS, [
                {
                    label: DIALOG_ACCEPT, action: function () {
                    UtilsHttp.refresh();
                }
                }
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(DIALOG_ERROR, FRM_USER_MODIFY_ERROR, [
                {label: DIALOG_ACCEPT}
            ], {className: "error"});
        });

    });
});


/**
 * Do the webservice call to cancel the account
 */
function calcelAccount() {
    $.post(WEBSERVICE_USER_UNREGISTER, function (data) {
        if (data == "") {
            UtilsHttp.refresh();
        }
        else {
            ManagerPopUp.dialog(DIALOG_ERROR, USER_UNREGISTER_ERROR, [{
                label: DIALOG_ACCEPT
            }], {className: "error"});
        }
    });
}