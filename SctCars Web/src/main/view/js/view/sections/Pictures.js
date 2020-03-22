$(document).ready(function () {
    SystemWeb.initializeSectionJs("pictures", function () {
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fadeUp",
            stopOnHover: true
        });
    });
});