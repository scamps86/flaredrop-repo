$(document).ready(function () {
    SystemWeb.initializeSectionJs("product", function () {

        // Initialize shared networks
        $("#socialNetworks").share({
            networks: ['facebook', 'twitter', 'pinterest', 'googleplus', 'linkedin'],
            theme: 'square'
        });

        // Slider
        $("#slider").owlCarousel({
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fade",
            stopOnHover: true
        });

        // Tab navigator
        new ComponentTabNavigator(undefined, $("#tn1"));

        // Get the product reference
        var productElement = $("#productContainer");

        // Initialize product refresh
        refreshProductDetail(parseInt($(productElement).attr("pauctionexpiretime")), "", [], $(productElement).attr("pcurrentprice"));

        // Add the params to the URL
        RPB_URL += "&" + UtilsHttp.encodeParams({"productId": $(productElement).attr("pid")});

        // Do a initial refresh
        $.get(RPB_URL, refreshBiddingSuccessHandler);

        // Initialize the refresh every 5 seconds
        setInterval(function () {
            $.get(RPB_URL, refreshBiddingSuccessHandler);
        }, 5000);

        // Define the place bid button click event
        $("#productContainer > .productPlaceBid").click(function () {
            if (!$(this).hasClass("disabled")) {
                $(this).addClass("disabled");
                placeBid($("#productContainer").attr("pid"));
            }
        });

        // Get the product buy now action
        $(".productBuyNow").click(function () {
            var pc = $("#productContainer");
            buyNow($(pc).attr("pid"), $(pc).attr("pname"), $(pc).attr("pprice"));
        });
    });
});


/**
 * Refresh bidding success handler
 *
 * @param data The service returning data
 */
function refreshBiddingSuccessHandler(data) {
    data = UtilsConversion.jsonToObject(data);

    if (data.bids.length > 0) {
        refreshProductDetail(data.bids[0].auctionExpireTime, data.bids[0].userNick, data.bids, data.bids[0].currentPrice);
    }

    // Validate if the product is in auction or not
    if (!data.inAuction) {
        $("#productContainer").addClass("sold");

        // Redirect to sold items
        UtilsHttp.goToUrl(SECTION_SOLD_URL);
    }
}


/**
 * Refresh the product
 *
 * @param remainingTime The time remaining in seconds
 * @param lastBid The last bid user nick
 * @param bidQueue The last bids queue array
 * @param currentPrice The current price
 */
function refreshProductDetail(remainingTime, lastBid, bidQueue, currentPrice) {

    // Get the product element
    var productElement = $("#productContainer");

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

    // Update the last bids queue
    $("#productLastBidsList").empty();

    var pair = false;

    $(bidQueue).each(function (k, v) {
        $("#productLastBidsList").append('<li class="row' + (pair ? ' pair' : '') + '"><span class="bidUserNick">' + v.userNick + '</span><span class="bidQuantity">' + UtilsFormatter.currency(v.currentPrice) + '</span></li>');
        pair = !pair;
    });
}