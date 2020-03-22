$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "goDown",
            stopOnHover: true
        });
    });

    // Works redirect
    $(".workItemContainer").click(function () {
        UtilsHttp.goToUrl($(this).attr("fdHref"), true);
    });
});