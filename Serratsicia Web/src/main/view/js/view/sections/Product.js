$(document).ready(function () {
    SystemWeb.initializeSectionJs("product", function () {
        $("#slider").owlCarousel({
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fadeUp",
            stopOnHover: true
        });

        $("#slider a").click(function (e) {
            e.preventDefault();
            ManagerPopUp.image($('<img src="' + $(this).attr("href") + '">'));
        });
    });
});