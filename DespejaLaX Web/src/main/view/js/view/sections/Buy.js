$(document).ready(function () {
    SystemWeb.initializeSectionJs("buy", function () {

        // Allow only numbers
        var selector = $("#ticketsSelector"),
            doBuy = $("#doBuy");

        $(selector).keypress(function (e) {
            if (e.keyCode > 47 && e.keyCode < 57) {
                if ($(this).val().length < 5) {
                    return true;
                }
            }
            return false;
        });

        $(selector).change(function () {
            var val = $(this).val();

            if (isNaN(val)) {
                $(this).val("1");
            }
            if (val != "") {
                $(this).val(Math.round(val));
            }
        });

        $(selector).keyup(function () {
            var val = $(this).val();

            if (isNaN(val)) {
                $(this).val("1");
            }

            if (val != "") {
                $(this).val(Math.round(val));
            }
        });

        // Listen buy button
        $(doBuy).click(function () {
            processBuy();
        });
    });
});


/**
 * Process the buy
 */
function processBuy() {
    var selector = $("#ticketsSelector"),
        price = $(selector).val();

    if (!isNaN(price) && price >= 1) {

        // Ve sure that price / quantity is an integer
        price = Math.round(price);

        var btn = UtilsPayPal.createBuyNowButton(undefined, PAYPAL_SANDBOX, {
            business: PAYPAL_BUSINESS,
            item_name: "DespejaLaX -  " + price + " " + TICKETS,
            currency_code: "EUR",
            amount: price,
            cpp_header_image: PAYPAL_HEADER_IMAGE_URL,
            notify_url: PAYPAL_NOTIFY_URL,
            custom: UtilsConversion.base64Encode(UtilsConversion.objectToJson([USER_ID, price]))
        });
        $("body").append(btn);
        $(btn).hide().submit();
    }
    else {
        alert("Quantitat no valida!");
    }
}

