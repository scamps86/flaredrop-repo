function ComponentSkinChanger() {

    // Define this component
    var component = this;

    // Define the component's container
    component.container = $('<div id="componentSkinChanger"></div>');

    // Define the component's label
    component.label = $("<p>" + ModelApplication.literals.get("SKIN_CHANGE_LABEL", "ManagerApp") + "</p>");

    // Define the options container
    component.optionsContainer = $('<div id="componentSkinChangerOptionsContainer"></div>');

    // Define the different skin options
    component.option_orange = $('<div id="componentSkinChangerOrange" class="componentSkinChangerOption transitionFast" skin="orange"></div>');
    component.option_red = $('<div id="componentSkinChangerRed" class="componentSkinChangerOption transitionFast" skin="red"></div>');
    component.option_green = $('<div id="componentSkinChangerGreen" class="componentSkinChangerOption transitionFast" skin="green"></div>');
    component.option_blue = $('<div id="componentSkinChangerBlue" class="componentSkinChangerOption transitionFast" skin="blue"></div>');
    component.option_purple = $('<div id="componentSkinChangerPurple" class="componentSkinChangerOption transitionFast" skin="purple"></div>');
    component.option_black = $('<div id="componentSkinChangerBlack" class="componentSkinChangerOption transitionFast" skin="black"></div>');

    // Do the appends
    $(component.optionsContainer).append(component.option_orange, component.option_red, component.option_green, component.option_blue, component.option_purple, component.option_black);
    $(component.container).append(component.label, component.optionsContainer);

    // Listen the option click events
    $(component.container).find(".componentSkinChangerOption").click(function () {
        component.change($(this).attr("skin"));
    });

    // Listen the label click event
    $(component.label).click(function () {
        $(this).fadeOut(200, function () {
            $(component.optionsContainer).fadeIn(200);
        });
    });
}


/**
 * Modify the current app skin and refresh it
 * @param skin
 */
ComponentSkinChanger.prototype.change = function (skin) {

    // Define this component
    var component = this;

    // Set application as waiting
    ViewApplication.wait();

    $.ajax({
        type: "POST",
        url: GLOBAL_URL_WEB_SERVICE_BASE + "SystemSkinSet",
        timeout: ModelApplication.ajaxTimeOut,
        data: {skin: skin},
        success: function () {
            location.reload();
        },
        error: function (e) {
            if (e.statusText == "timeout") {
                component.change(skin);
            }
            else {
                // Set application as not waiting
                ViewApplication.closeWait();

                // Show error popup
                ManagerPopUp.dialog(ModelApplication.literals.get("ERROR", "ManagerApp"), ModelApplication.literals.get("SET_SKIN_ERROR", "ManagerApp"), [
                    {label: ModelApplication.literals.get("ACCEPT", "ManagerApp")}
                ], {className: "error"});
            }
        }
    });
};