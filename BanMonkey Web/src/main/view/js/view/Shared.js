$(document).ready(function () {
    // User login option click event
    $("#userMenuOptionLogin").click(function () {
        showLoginPopUp();
    });

    // User logout
    $("#userOptionLogout").click(function () {
        userLogout();
    });
});


/**
 * Place a bid
 *
 * @param productId The product id
 */
function placeBid(productId) {
    $.post(PB_URL, {productId: productId}, function (data) {
        if (data != "") {
            if (data == "BANS") {
                ManagerPopUp.dialog(DIALOG_ERROR, BID_NOBANS_ERROR, [{
                    label: DIALOG_ACCEPT, action: function () {
                        UtilsHttp.goToUrl(SECTION_USER_BUY_BANS_URL);
                    }
                }, {label: DIALOG_CANCEL}], {className: "error"});
            }
            else if (data == "CURRENT") {
                ManagerPopUp.dialog(DIALOG_ERROR, BID_CURRENT_ERROR, [{
                    label: DIALOG_ACCEPT
                }], {className: "error"});
            }
            else {
                ManagerPopUp.dialog(DIALOG_ERROR, BID_ERROR, [{label: DIALOG_ACCEPT}], {className: "error"});
            }
        }
        else {
            // Show bid success popup
            ManagerPopUp.dialog(DIALOG_SUCCESS, BID_SUCCESS, [{
                label: DIALOG_ACCEPT
            }], {className: "success"});
        }
        $(".productPlaceBid").removeClass("disabled");
    });
}


/**
 * Buy a product directly
 *
 * @param productId The product id
 * @param productName The product name
 * @param productPrice The product price
 *
 */
function buyNow(productId, productName, productPrice) {
    var btn = UtilsPayPal.createBuyNowButton(undefined, PAYPAL_SANDBOX, {
        business: PAYPAL_BUSINESS,
        item_name: productName,
        currency_code: "EUR",
        amount: parseFloat(productPrice),
        cpp_header_image: PAYPAL_HEADER_IMAGE_URL,
        notify_url: PAYPAL_BUY_NOW_NOTIFY_URL,
        custom: UtilsConversion.base64Encode(productId)
    });
    $("body").append(btn);
    $(btn).hide().submit();
}


/**
 * Do the user logout
 */
function userLogout() {
    $.post(ULO_URL, {
        diskId: DISK_WEB_ID
    }, function () {
        UtilsHttp.refresh();
    });
}


/**
 * Show a login popup
 */
function showLoginPopUp() {
    var form = $('<form class="componentForm" id="userLoginForm"><div class="componentFormInputContainer"><input type="hidden" validate="" validatecondition="AND" name="diskId" validateerrormessage="" value="2"></div><div class="componentFormInputContainer"><p>' + FRM_NICK + ' *</p><input type="text" validate="fill" validatecondition="AND" name="xLOG1" validateerrormessage="" value=""></div><div class="componentFormInputContainer"><p>' + FRM_PASSWORD + ' *</p><input type="password" validate="fill;password" validatecondition="AND" name="xLOG2" validateerrormessage="" value=""></div><div class="componentFormInputContainer"><input type="submit" validate="" validatecondition="AND" validateerrormessage="" value="' + FRM_LOG_IN + '"></div></form>');
    $(form).attr("serviceurl", ULI_URL);

    // Show the popup
    var w = ManagerPopUp.window(FRM_LOG_IN, form);

    $(w).append('<p id="loginNoRemember">' + FRM_USER_LOGIN_NO_REMEMBER + '</p>');

    // Add the click event to the loginNoRemember option
    $("#loginNoRemember").click(function () {
        showResetPasswordPopUp();
    });

    // Login form to the manager
    ManagerForm.add(form, function () {
        UtilsHttp.goToUrl(SECTION_USER_BUY_BANS_URL);
    }, function () {
        ManagerPopUp.dialog(DIALOG_ERROR, FRM_LOGIN_ERROR, [
            {label: DIALOG_ACCEPT}
        ], {className: "error"});
    });
}


/**
 * Show remember password popup
 */
function showResetPasswordPopUp() {
    var form = $('<form class="componentForm" id="userResetForm"><div class="componentFormInputContainer"><p>' + FRM_USER_RESET_NAME + '</p><input type="text" name="name" validateerrormessage="" value="" placeholder="Nombre de usuario"><input type="text" name="userEmail" validateerrormessage="" value="" placeholder="Correo electrónico"></div><div class="componentFormInputContainer"><input type="submit" validate="fill" validatecondition="AND" validateerrormessage="" value="' + FRM_USER_RESET_RESET + '"></div></form>');
    $(form).attr("serviceurl", ULR_URL);
    $(form).append('<input type="hidden" name="senderEmail" value="' + MAIL_NOREPLY + '" />');
    $(form).append('<input type="hidden" name="emailContentsBundle" value="Mailing" />');
    $(form).append('<input type="hidden" name="emailSubjectKey" value="RESET_PASSWORD_SUBJECT" />');
    $(form).append('<input type="hidden" name="emailMessageKey" value="RESET_PASSWORD_MESSAGE" />');

    // Show the popup
    ManagerPopUp.window(FRM_USER_RESET, form, {width: 400});

    // User remember password form to the manager
    ManagerForm.add(form, function () {
        ManagerPopUp.dialog(DIALOG_ERROR, FRM_PASSWORD_REMEMBER_SUCCESS, [
            {
                label: DIALOG_ACCEPT,
                action: function () {
                    ManagerPopUp.closeAll();
                }
            }
        ], {className: "success"});
    }, function () {
        ManagerPopUp.dialog(DIALOG_ERROR, FRM_PASSWORD_REMEMBER_ERROR, [
            {label: DIALOG_ACCEPT}
        ], {className: "error"});
    });
}


/**
 * Show the user conditions
 */
function showUserConditionsPopUp() {
    ManagerPopUp.window(USER_CONDITIONS_TITLE, $("#userConditions").html(), {width: 600});
}