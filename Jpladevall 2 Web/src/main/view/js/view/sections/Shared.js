$(document).ready(function () {
    var s = new Shared();

    // User logout
    $("#headerUserLogout").click(function () {
        s.userLogout();
    });

    // Footer map
    if ($("#footerMap").length) {
        UtilsGoogleMaps.generateMap($("#footerMap"), 41.566495, 2.0033669, 14);
    }

    // Newsletter subscribe
    $("#joinNewsletterBtn").click(function () {
        s.joinNewsletter($(this).prev().val());
    });

    // Top cart
    $("#topCart").click(function () {
        $("#topCartDrop").toggleClass('opened');
    });
    ManagerShoppingCart.setUnitsElement("#topCartDrop .cartTopUnits");
    ManagerShoppingCart.setTotalPriceElement("#topCartDrop .cartTopTotalPrice");

    // Related brands
    var relatedBrandsElement = $(".relatedBrands .relatedBrandsSlider");

    if (relatedBrandsElement.length > 0) {
        $(relatedBrandsElement).owlCarousel({
            paginationSpeed: 400,
            singleItem: false,
            transitionStyle: "fadeUp",
            stopOnHover: true,
            pagination: false,
            navigation: true,
            items: 6,
            navigationText: ['<', '>']
        });
    }

    // Add to cart listener
    $(".addToCartBtn").click(s.addToCart);
});


function Shared() {
}


/**
 * Do the user logout and refresh the current section to be redirected to the home
 */
Shared.prototype.userLogout = function () {
    $.post(WEBSERVICE_LOGOUT, {
        diskId: DISK_WEB_ID
    }, function () {
        UtilsHttp.refresh();
    });
};


/**
 * Send ajax request to join into newsletter
 *
 * @param {string} email
 */
Shared.prototype.joinNewsletter = function (email) {

    if (UtilsValidation.isEmail(email)) {
        $.post(WEBSERVICE_NEWSLETTER_JOIN, {
            frmEmail: email
        }, function () {
            ManagerPopUp.dialog(DIALOG_SUCCESS, FRM_NEWSLETTER_JOIN_SUCCESS, [
                {label: DIALOG_ACCEPT}
            ], {className: "success"});
        });
    }
};


/**
 * Add an item to the cart
 */
Shared.prototype.addToCart = function () {
    if (SHOPPING_CART_PRODUCTS) {

        var item = ManagerShoppingCart.utilSystemDiskObjectToItem(SHOPPING_CART_PRODUCTS, $(this).attr("pid"));

        item.pictureUrl = $(this).attr("purl");
        item.units = parseInt($(this).attr("punits"));

        if (ManagerShoppingCart.setItem(item)) {
            ManagerShoppingCart.render();
            ManagerPopUp.dialog("", MESSAGE_CART_SETITEM_SUCCESS, [{label: "Ok"}, {
                label: BUTTON_CART_GO_TO_MYCART, action: function () {
                    UtilsHttp.goToUrl(SECTION_MY_CART);
                }
            }], {className: "success"})
        }
        else {
            ManagerPopUp.dialog(DIALOG_ERROR, MESSAGE_CART_SETITEM_ERROR, [{label: "Ok"}], {className: "error"});
        }
    }
    else {
        ManagerPopUp.dialog(DIALOG_ERROR, MESSAGE_CART_SETITEM_ERROR, [{label: "Ok"}], {className: "error"});
    }
};