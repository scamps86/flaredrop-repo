$(document).ready(function () {
    var shared = new _shared();
});


function _shared() {

    // On mobile top menu button click, show the menu
    $(document).click(function (e) {
        if ($(e.target).attr("id") == "mobileTopMenuBtn") {
            $("#mobileTopMenuContainer").toggleClass("expanded");
        }
        else {
            $("#mobileTopMenuContainer").removeClass("expanded");
        }
    });

}