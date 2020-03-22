$(document).ready(function () {
    SystemWeb.initializeSectionJs("producte", function () {
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fade",
            stopOnHover: true
        });

        // Define the picture clicks
        $("#slider a").click(function (e) {
            e.preventDefault();
            ManagerPopUp.image($('<img src="' + $(this).attr("href") + '">'));
        });

        // Buy button
        $("a.buyBtn").click(function (e) {
            e.preventDefault();
            var url = $(this).attr("href");
            UtilsHttp.goToUrl(url, true);
        });
    });
});