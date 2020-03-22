$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {
        // Slider
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "goDown",
            stopOnHover: true,
            navigation: true,
            navigationText: ['<', '>'],
            pagination: false
        });

        if ($("#sliderSchedules")) {
            $("#sliderSchedules").owlCarousel({
                autoPlay: 6000,
                paginationSpeed: 400,
                singleItem: true,
                transitionStyle: "fade",
                stopOnHover: true,
                navigation: false,
                pagination: false
            });
        }

        // Calculate each auction product countdowns
        $("#inAuctionProductsContainer > li").each(function () {
            refreshProduct(this, parseInt($(this).attr("pauctionexpiretime")), "", $(this).attr("pcurrentprice"));
        });

        // Do a initial refresh
        $.get(RAB_URL, refreshAllBiddingSuccessHandler);

        // Initialize the refresh every 5 seconds
        setInterval(function () {
            $.get(RAB_URL, refreshAllBiddingSuccessHandler);
        }, 5000);

        // Define the place bid button click event
        $("#inAuctionProductsContainer > li .productPlaceBid").click(function () {
            if (!$(this).hasClass("disabled")) {
                $(this).addClass("disabled");
                placeBid($(this).parents("li").attr("pid"));
            }
        });

        // User validation
        if (USER_VALIDATION_SUCCESS == 1) {
            ManagerPopUp.dialog(DIALOG_SUCCESS, USER_VALIDATION_SUCCESS_MESSAGE, [
                {label: DIALOG_ACCEPT}
            ], {className: "success"});
        }
    });
});


/**
 * Refresh all bidding success handler
 *
 * @param data The service returning data
 */
function refreshAllBiddingSuccessHandler(data) {
    data = UtilsConversion.jsonToObject(data);

    $(data.productsLastBid).each(function (k, v) {
        refreshProduct($("#pid-" + v.objectId), v.auctionExpireTime, v.userNick, v.currentPrice);
    });

    // Set products as sold
    $("#inAuctionProductsContainer > li").each(function (k, element) {

        var inAuction = false;

        $(data.auctionProductIds).each(function (kk, pid) {
            if ($(element).attr("pid") == pid) {
                inAuction = true;
                return false;
            }
        });

        if (!inAuction) {
            $(element).addClass("sold");
        }
    });
}


/**
 * Refresh the products
 *
 * @param productElement The product container element
 * @param remainingTime The time remaining in seconds
 * @param lastBid The last bid user nick
 * @param currentPrice The current price
 */
function refreshProduct(productElement, remainingTime, lastBid, currentPrice) {
    // Get the product id
    var pid = $(productElement).attr("id");

    // Update the current price
    $(productElement).find(".productCurrentPrice").html(UtilsFormatter.currency(currentPrice));

    // Update the countdown
    UtilsTimer.stopCountdown(pid);

    // Update the last bid nickname
    lastBid = lastBid == "" ? PRODUCT_NOBODY : lastBid;
    $(productElement).find(".productLastBid span").html(lastBid.substring(0, 10));

    if (remainingTime > -1) {
        UtilsTimer.countdown($(productElement).find(".productRemainingTime"), pid, remainingTime, 1000, undefined, undefined, function () {
            UtilsTimer.stopCountdown(pid);
        });
    }
}