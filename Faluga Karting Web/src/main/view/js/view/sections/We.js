$(document).ready(function () {
    SystemWeb.initializeSectionJs("we", function () {
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fade",
            stopOnHover: true
        });
    });
});