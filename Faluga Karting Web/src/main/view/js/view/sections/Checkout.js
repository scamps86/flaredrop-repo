$(document).ready(function () {
    SystemWeb.initializeSectionJs("checkout", function () {

        // Set the shopping cart after render callback
        ManagerShoppingCart.setAfterRenderCallback(function () {
            if (ManagerShoppingCart.getTotalUnits() > 0) {
                $("#checkoutForm input[type=submit]").removeAttr('disabled');
            }
            else {
                $("#checkoutForm input[type=submit]").attr('disabled', 'disabled');
            }
            $("#checkoutForm input[name=frmCart]").val(UtilsConversion.base64Encode(UtilsConversion.objectToJson(ManagerShoppingCart.getCart())));
            $("#checkoutForm input[name=frmTotalPrice]").val(ManagerShoppingCart.getTotalPrice());
        });

        // Define the shopping cart literals
        ManagerShoppingCart.overrideLiterals(SHOPPING_CART_LITERALS);

        // Define the cart container element
        ManagerShoppingCart.setParentElement("#cartContainer");

        // Checkout form send
        ManagerForm.add($("#checkoutForm"), function () {
            checkoutSuccess();
        }, function (data) {
            if (data !== "") {
                checkoutSuccess(data.target.responseText);
            }
            else {
                ManagerPopUp.dialog(dialogError, FRM_CHECKOUT_ERROR, [
                    {label: "ok"}
                ], {className: "error"});
            }
        });


        /**
         * Do checkout operation
         *
         * @param {Object} order (only used for TPV)
         */
        function checkoutSuccess(order) {
            ManagerPopUp.dialog(dialogSuccess, FRM_CHECKOUT_SUCCESS, [
                {
                    label: "ok", action: function () {

                    // Get the payment method
                    var PAYMENT_METHOD = $("#payModeSelector input").val();

                    // Get the shopping cart info
                    var PAYPAL_CUSTOM = ManagerShoppingCart.payPalGenerateCustom(),
                        PAYPAL_ITEM_NAME = ManagerShoppingCart.payPalGenerateItemName(),
                        PAYPAL_AMOUNT = ManagerShoppingCart.getTotalPrice();

                    // Create the PayPal and TPV buttons and click it
                    if (PAYPAL_CUSTOM != "") {

                        if (PAYMENT_METHOD === "paypal") {
                            var ppBtn = UtilsPayPal.createBuyNowButton(undefined, PAYPAL_USE_SANDBOX, {
                                business: PAYPAL_BUSINESS,
                                item_name: PAYPAL_ITEM_NAME,
                                currency_code: "EUR",
                                amount: PAYPAL_AMOUNT,
                                cpp_header_image: PAYPAL_CPP_HEADER_IMAGE,
                                notify_url: PAYPAL_NOTIFY_URL,
                                custom: PAYPAL_CUSTOM
                            }, "pay");
                            $("body").append(ppBtn);
                            $(ppBtn).hide().submit();
                        }
                        else if (PAYMENT_METHOD === "tpv" && order !== "") {
                            UtilsTpv.sendTpvRequest(undefined, {
                                url_tpvv: TPV_URL_TPVV,
                                order: order,
                                code: TPV_CODE,
                                terminal: TPV_TERMINAL,
                                transactionType: 0,
                                currency: TPV_CURRENCY,
                                amount: PAYPAL_AMOUNT,
                                urlMerchant: TPV_NOTIFY_URL,
                                dataMerchant: PAYPAL_CUSTOM
                            }, "pay", TPV_SIGNATURE_GET);
                        }
                        else {
                            ManagerPopUp.dialog(dialogError, FRM_CHECKOUT_ERROR, [
                                {label: "ok"}
                            ], {className: "error"});
                        }
                    }
                    else {
                        ManagerPopUp.dialog(dialogError, FRM_CHECKOUT_ERROR, [
                            {label: "ok"}
                        ], {className: "error"});
                    }
                }
                }
            ], {className: "success"});
        }

    });
});