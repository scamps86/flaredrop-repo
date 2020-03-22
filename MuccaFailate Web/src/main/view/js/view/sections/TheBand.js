$(document).ready(function () {
    SystemWeb.initializeSectionJs("theband", function () {
        $("#membersSlider").owlCarousel({
            autoPlay: false,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "backSlide",
            stopOnHover: true
        });
    });
});