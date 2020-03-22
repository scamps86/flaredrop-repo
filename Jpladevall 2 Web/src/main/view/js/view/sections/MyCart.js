$(document).ready(function () {
    SystemWeb.initializeSectionJs("myCart", function () {

        // Define the shopping cart units element
        ManagerShoppingCart.setParentElement("#cartContainer");

        // Override shopping cart literals
        ManagerShoppingCart.overrideLiterals({
            units: '',
            price: '',
            taxes: '',
            remove: CART_REMOVE,
            cancel: CART_CANCEL,
            alert: CART_ALERT,
            emptyCart: CART_EMPTY_CART,
            shippingPrice: '',
            totalPrice: CART_TOTAL_PRICE,
            sureEmptyCart: CART_SURE_EMPTY_CART,
            sureRemoveItem: CART_SURE_REMOVE_ITEM,
            noItems: CART_EMPTY
        });

        // Render the cart
        ManagerShoppingCart.render();

        // PICTURE MODALS
        ManagerShoppingCart.setAfterRenderCallback(function () {
            $("#cartContainer .componentShoppingCartItemPicture").click(function (e) {
                console.log('ok');
                e.preventDefault();
                ManagerPopUp.image($('<img src="' + $(this).attr("src") + '">'));
            });
        });

        $("#checkoutBtn").click(function () {
            var payPalCustom = ManagerShoppingCart.payPalGenerateCustom();

            debugger;
            if (payPalCustom !== '') {
                var btn = UtilsPayPal.createBuyNowButton(undefined, PAYPAL_SANDBOX, {
                    business: PAYPAL_BUSINESS,
                    item_name: ManagerShoppingCart.payPalGenerateItemName(),
                    currency_code: 'EUR',
                    amount: ManagerShoppingCart.getTotalPrice(),
                    notify_url: WEBSERVICE_PAYPAL_IPN,
                    custom: payPalCustom
                });
                $('body').append(btn);
                $(btn).hide().submit();
            }
        });
    });
});