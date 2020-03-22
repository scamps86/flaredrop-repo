$(document).ready(function () {
    SystemWeb.initializeSectionJs("privateHome", function () {

        // TOP SLIDER
        $("#privateHomeSlider").owlCarousel({
            autoPlay: 6000,
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fadeUp",
            stopOnHover: true,
            afterMove: function (a) {
                setTimeout(function () {
                    $("#privateHomeSlider .sliderContent").addClass('show');
                }, 1000);
            },
            beforeMove: function (a) {
                $("#privateHomeSlider .sliderContent").removeClass('show');
            }
        });

        // CARRUSEL CONFIG
        var cConfig = {
            autoPlay: 6000,
            paginationSpeed: 400,
            pagination: false,
            items: 3,
            singleItem: false,
            stopOnHover: true,
            navigation: true
        };

        // NEW PRODUCTS SLIDER
        $("#newProductsSlider").owlCarousel(cConfig);

        // SHUFFLE PRODUCTS SLIDER
        $("#shuffleProductsSlider").owlCarousel(cConfig);

        var owl = $("#newProductsSlider").data('owlCarousel');
        var owl2 = $("#shuffleProductsSlider").data('owlCarousel');
        owl.resizer();
        owl2.resizer();

    });
});