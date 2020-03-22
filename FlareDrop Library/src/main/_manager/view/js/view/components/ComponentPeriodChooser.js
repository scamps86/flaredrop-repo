/**
 * Create the component period chooser
 *
 * @param moduleComponent The module component
 * @param parentElement The parent element
 * @param className The class name for the component. Not mandatory
 */
function ComponentPeriodChooser(moduleComponent, parentElement, className) {

    // Define this component
    var component = this;

    // Define the module component
    component.moduleComponent = moduleComponent;

    // Define the parent element
    component.parentElement = parentElement;

    // Define component's constants
    component.PERIOD_ALL = "ALL";
    component.PERIOD_WEEK = "WEEK";
    component.PERIOD_MONTH = "MONTH";
    component.PERIOD_QUARTER = "QUARTER";
    component.PERIOD_SEMESTER = "SEMESTER";
    component.PERIOD_YEAR = "YEAR";

    // Define the container
    component.container = $('<div class="componentPeriodChooser unselectable"></div>');

    // Add the custom class only if defined
    if (className !== undefined) {
        $(component.container).addClass(className);
    }

    // Define the main label
    component.label = $('<p class="componentPeriodChooserLabel">' + ModelApplication.literals.get("FILTER_PERIOD_ALL", "ManagerApp") + '</p>');

    // Define the main button
    component.btn = $('<div class="skinIcon periodBtn componentPeriodChooserBtn"></div>');

    // Define the dropdown menu
    component.dropDown = $('<ul class="componentPeriodChooserDropDown"></ul>');
    $(component.dropDown).hide();

    // Define the dropdown options
    component.optAll = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_ALL", "ManagerApp") + "</li>");
    $(component.optAll).attr("period", component.PERIOD_ALL);

    component.optWeek = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_WEEK", "ManagerApp") + "</li>");
    $(component.optWeek).attr("period", component.PERIOD_WEEK);

    component.optMonth = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_MONTH", "ManagerApp") + "</li>");
    $(component.optMonth).attr("period", component.PERIOD_MONTH);

    component.optQuarter = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_QUARTER", "ManagerApp") + "</li>");
    $(component.optQuarter).attr("period", component.PERIOD_QUARTER);

    component.optSemester = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_SEMESTER", "ManagerApp") + "</li>");
    $(component.optSemester).attr("period", component.PERIOD_SEMESTER);

    component.optYear = $("<li>" + ModelApplication.literals.get("FILTER_PERIOD_YEAR", "ManagerApp") + "</li>");
    $(component.optYear).attr("period", component.PERIOD_YEAR);

    // Do the appends to the dropDown menu
    $(component.dropDown).append(component.optAll, component.optWeek, component.optMonth, component.optQuarter, component.optSemester, component.optYear, component.optCustom);

    // Do the appends to the container
    $(component.container).append(component.btn, component.label, component.dropDown);

    // Append the component to the parent element
    $(component.parentElement).append(component.container);

    // Define the component main button click event
    $(document).click(function (e) {
        if (!$(e.target).hasClass("componentPeriodChooserBtn") && !$(e.target).hasClass("componentPeriodChooserLabel")) {

            $(component.dropDown).slideUp(200);
        }
        else {

            $(component.dropDown).slideDown(200);
        }
    });


    // Define dropDown option click event
    $(component.dropDown).find("li").click(function () {

        component.periodSelect($(this).attr("period"));
    });
}


/**
 * Select a period
 *
 * @param period The period: can be: ALL, WEEK, MONTH, QUARTER, SEMESTER, YEAR, CUSTOM
 */
ComponentPeriodChooser.prototype.periodSelect = function (period) {

    // Define this component
    var component = this;

    // Get the actual date + 1 day to get also the current day
    var actualDate = UtilsDate.toMySQL(UtilsDate.operate("DAY", UtilsDate.create()));

    // Define the initial date
    var initialDate = null;

    // Do the initial date calculations depending of the selected period
    switch (period) {
        case component.PERIOD_ALL:
            initialDate = null;
            break;
        case component.PERIOD_WEEK:
            initialDate = UtilsDate.operate("DAY", UtilsDate.create(), 7, false);
            break;
        case component.PERIOD_MONTH:
            initialDate = UtilsDate.operate("MONTH", UtilsDate.create(), 1, false);
            break;
        case component.PERIOD_QUARTER:
            initialDate = UtilsDate.operate("MONTH", UtilsDate.create(), 3, false);
            break;
        case component.PERIOD_SEMESTER:
            initialDate = UtilsDate.operate("MONTH", UtilsDate.create(), 6, false);
            break;
        case component.PERIOD_YEAR:
            initialDate = UtilsDate.operate("YEAR", UtilsDate.create(), 1, false);
            break;
    }

    // Reset the selected period
    component.moduleComponent.modeler.selectedPeriod = null;

    if (initialDate != null) {

        // Substract one day to get also the fisrt day
        initialDate = UtilsDate.operate("DAY", initialDate, 1, false);

        // Update the selected period label
        component.moduleComponent.modeler.selectedPeriod = [UtilsDate.toMySQL(initialDate), actualDate];
    }

    // Update the selected period label
    $(component.label).html(ModelApplication.literals.get("FILTER_PERIOD_" + period, "ManagerApp"));

    // Call the controller to get the list
    component.moduleComponent.modeler.currentPage = 0;
    component.moduleComponent.controller.objectsGet();
};