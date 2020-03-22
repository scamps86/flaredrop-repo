$(document).ready(function () {
    SystemWeb.initializeSectionJs("sold", function () {
        // Slider
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "goDown",
            stopOnHover: true,
            navigation: false,
            pagination: false
        });
    });
});