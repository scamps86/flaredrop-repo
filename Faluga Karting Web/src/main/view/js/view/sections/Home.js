$(document).ready(function () {
    SystemWeb.initializeSectionJs("home", function () {
        $("#slider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "goDown",
            stopOnHover: true
        });

        $("li.productItem").click(function () {
            ManagerPopUp.image($('<img src="' + $(this).attr("full-img") + '" />'));
        });
    });
});