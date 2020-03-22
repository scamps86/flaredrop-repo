$(document).ready(function () {
    SystemWeb.initializeSectionJs("userBuyBans", function () {
        $("#banPacksList button").click(function () {
            var btn = UtilsPayPal.createBuyNowButton(undefined, PAYPAL_SANDBOX, {
                business: PAYPAL_BUSINESS,
                item_name: $(this).parent("li").attr("ptitle"),
                currency_code: "EUR",
                amount: parseFloat($(this).parent("li").attr("pprice")),
                cpp_header_image: PAYPAL_HEADER_IMAGE_URL,
                notify_url: PAYPAL_BUY_BANS_NOTIFY_URL,
                custom: UtilsConversion.base64Encode(UtilsConversion.objectToJson([USER_ID, $(this).parent("li").attr("pid")]))
            });
            $("body").append(btn);
            $(btn).hide().submit();
        });
    });
});