$(document).ready(function () {
    SystemWeb.initializeSectionJs("userAccount", function () {

        // Cancel account button click
        $("#cancelAccountBtn").click(function () {
            ManagerPopUp.dialog(DIALOG_ALERT, CANCEL_ACCOUNT_SURE, [{
                label: DIALOG_ACCEPT, action: function () {
                    calcelAccount();
                }
            }, {label: DIALOG_CANCEL}], {className: "warning"});

        });

        // Update form send
        ManagerForm.add($("#userDataForm"), function () {
            ManagerPopUp.dialog(DIALOG_SUCCESS, FRM_USER_DATA_SUCCESS, [
                {
                    label: DIALOG_ACCEPT, action: function () {
                    UtilsHttp.refresh();
                }
                }
            ], {className: "success"});
        }, function () {
            ManagerPopUp.dialog(DIALOG_ERROR, FRM_USER_DATA_ERROR, [
                {label: DIALOG_ACCEPT}
            ], {className: "error"});
        });
    });
});


/**
 * Do the webservice call to cancel the account
 */
function calcelAccount() {
    $.post(AC_URL, function (data) {
        if (data == "") {
            UtilsHttp.refresh();
        }
        else {
            ManagerPopUp.dialog(DIALOG_ERROR, CANCEL_ACCOUNT_ERROR, [{
                label: DIALOG_ACCEPT
            }], {className: "error"});
        }
    });
}