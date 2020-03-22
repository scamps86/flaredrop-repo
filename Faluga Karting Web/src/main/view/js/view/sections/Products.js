$(document).ready(function () {
    SystemWeb.initializeSectionJs("products", function () {

        // Add the add to cart listener
        $("#productsList p.productAddToCart span").click(function () {

            var p = $(this).parent(),
                units = $(this).prev("input").val(),
                item = ManagerShoppingCart.utilSystemDiskObjectToItem(PRODUCTS, $(p).attr("pid"));

            // Validate the input
            if (isNaN(units) || units < 1) {
                units = 1;
            }
            else {
                units = Math.floor(units);
            }

            $(this).prev().val(units);

            item.url = $(p).attr("purl");
            item.price = parseFloat($(p).attr("pprice"));
            item.units = units;

            if (ManagerShoppingCart.setItem(item)) {
                ManagerPopUp.dialog("", MESSAGE_CART_SETITEM_SUCCESS, [{label: BUTTON_CONTINUE}, {
                    label: BUTTON_CART_GO_TO_MYCART, action: function () {
                        UtilsHttp.goToUrl(SECTION_CHECKOUT_URL);
                    }
                }], {className: "success"})
            }
            else {
                ManagerPopUp.dialog(MESSAGE_ERROR, MESSAGE_CART_SETITEM_ERROR, [{label: "Ok"}], {className: "error"});
            }
        });

        // Show picture popup
        $("#productsRight img").click(function () {
            var img = $("<img />");
            $(img).attr("src", $(this).attr("dsrc"));
            ManagerPopUp.image(img);
        });
    });
});