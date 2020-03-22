/**
 * Locale changer custom element
 */
function ComponentLocaleChanger() {

    // Define this component
    var component = this;

    // Define the component container
    component.container = $('<div id="literalContainer"></div>');

    // Loop all application literals defined on the configuration
    $(ModelApplication.literals.getLanTags()).each(function (k, v) {
        var language = v.substring(0, 2);
        var option = $('<p class="literal" literal="' + v + '" language="' + language + '">' + language + "</p>");
        $(component.container).append(option);

        // Add the literal change events
        $(option).click(function () {
            UtilsCookie.set("lan", $(this).attr("literal"));
            window.location.href = GLOBAL_URL_MANAGER_LOGIN.substring(0, GLOBAL_URL_MANAGER_LOGIN.length - 2) + $(this).attr("language");
        });
    });
}

