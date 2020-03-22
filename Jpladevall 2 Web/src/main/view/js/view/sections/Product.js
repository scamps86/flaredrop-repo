$(document).ready(function () {
    SystemWeb.initializeSectionJs("product", function () {

        // PICTURE SLIDER
        $("#productPictures").owlCarousel({
            paginationSpeed: 400,
            singleItem: true,
            transitionStyle: "fadeUp",
            stopOnHover: true
        });

        // PICTURE MODALS
        $("#productPictures a").click(function (e) {
            e.preventDefault();
            ManagerPopUp.image($('<img src="' + $(this).attr("href") + '">'));
        });

        // Cart units selector
        var unitsElement = $("#addToCartOptions .cartUnitSelectorUnits"),
            addToCartBtnElement = $("#addToCartOptions .addToCartBtn"),
            units = 1;

        $(unitsElement).html(units);

        $("#addToCartOptions .cartUnitSelectorRemove").click(function () {
            units--;
            units = units < 1 ? 1 : units;
            $(unitsElement).html(units);
            $(addToCartBtnElement).attr('punits', units);
        });
        $("#addToCartOptions .cartUnitSelectorAdd").click(function () {
            units++;
            units = units > 10 ? 10 : units;
            $(unitsElement).html(units);
            $(addToCartBtnElement).attr('punits', units);
        });
    });
});