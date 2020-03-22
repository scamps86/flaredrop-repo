$(document).ready(function () {
    SystemWeb.initializeSectionJs("shows", function () {
        var img = null;
        $("#showsContainer .showPicture").click(function () {
            img = $('<img src="' + $(this).attr("full-url") + '" />');
            ManagerPopUp.image(img);
        });
    });
});