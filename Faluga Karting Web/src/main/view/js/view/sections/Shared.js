$(document).ready(function () {

    // Catalog button
    $("#headerCatalogBtn").click(function () {
        $("#headerCatalogContainer").slideToggle(400);
    });

    // Mobile menu button
    $("#headerBottomMobileBtn").click(function () {
        $("#headerMainMenuMobileContainer").slideToggle(400);
    });

    // Define the shopping cart units element
    ManagerShoppingCart.setUnitsElement(".shcrtUnits");

    // Render the cart
    ManagerShoppingCart.render();
});