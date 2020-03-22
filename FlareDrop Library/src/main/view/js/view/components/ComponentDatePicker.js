/**
 * Component DatePicker
 *
 * @param inputBaseElement The input element (tyoe=text as recomended)
 * @param options The possible options object for the component: "inputBasePlaceholder", "inputBaseName", "currentDate", "width", "showHourContainer"
 * @param literals The literals object for the component: {months : {JANUARY : '', FEB...}, days : {MONDAY : '', THU...}, hour : '', minute : '', second : '', select : '', mainTitle : ''}
 * @param onSelectCallback The callback called when the date is selected
 */
function ComponentDatePicker(inputBaseElement, options, literals, onSelectCallback) {
    // Define this component
    var component = this;

    // Load options & defaults
    if (options == undefined) {
        options = {};
    }

    options.inputBasePlaceholder = options.inputBasePlaceholder || "";
    options.inputBaseName = options.inputBaseName || "";
    options.currentDate = options.currentDate || UtilsDate.create(new Date().getFullYear(), new Date().getMonth() + 1, new Date().getDate());
    options.width = options.width || 350;
    options.showHourContainer = options.showHourContainer || true;

    component.options = options;

    // Load literals
    if (literals == undefined) {
        literals = {};
    }

    literals.months = literals.months || {
            JANUARY: 'January',
            FEBRUARY: 'February',
            MARCH: 'March',
            APRIL: 'April',
            MAY: 'May',
            JUNE: 'June',
            JULY: 'July',
            AUGUST: 'August',
            SEPTEMBER: 'September',
            OCTOBER: 'October',
            NOVEMBER: 'November',
            DECEMBER: 'December'
        };

    literals.days = literals.days || {
            MONDAY: "Mon",
            TUESDAY: "Thu",
            WEDNESDAY: "Wed",
            THURSDAY: "Thu",
            FRIDAY: "Fri",
            SATURDAY: "Sat",
            SUNDAY: "Sun"
        };

    literals.hour = literals.hour || "Hour";
    literals.minute = literals.minute || "Minute";
    literals.second = literals.second || "Second";
    literals.select = literals.select || "Select date";
    literals.mainTitle = literals.mainTitle || "Select a date";

    component.literals = literals;

    // Define the on select callback
    component.onSelectCallback = onSelectCallback;

    // Create a text input element
    component.inputBaseElement = inputBaseElement;
    $(component.inputBaseElement).attr({
        "name": component.options.inputBaseName,
        "class": "componentDatePickerInputBaseElement",
        "placeholder": component.options.inputBasePlaceHolder,
        readonly: "readonly"
    });

    // Do the appends
    $(component.parent).append(component.inputBaseElement);
    $(component.parent).append(component.container);

    // Define the input base click event
    $(component.inputBaseElement).click(function () {
        component._show();
    });
}


/**
 * Get the datepicker selected date
 */
ComponentDatePicker.prototype.getCurrentDate = function () {
    // Define this component
    var component = this;
    return component.currentDate;
};


/**
 * Go to next month
 */
ComponentDatePicker.prototype.goToNextMonth = function () {
    // Define this component
    var component = this;
    component.currentDate = UtilsDate.operate("MONTH", component.currentDate, 1);
    component.refresh();
};


/**
 * Go to previous month
 */
ComponentDatePicker.prototype.goToPreviousMonth = function () {
    // Define this component
    var component = this;
    component.currentDate = UtilsDate.operate("MONTH", component.currentDate, 1, false);
    component.refresh();
};


/**
 * Go to next year
 */
ComponentDatePicker.prototype.goToNextYear = function () {
    // Define this component
    var component = this;
    component.currentDate = UtilsDate.operate("YEAR", component.currentDate, 1);
    component.refresh();
};


/**
 * Go to previous year
 */
ComponentDatePicker.prototype.goToPreviousYear = function () {
    // Define this component
    var component = this;
    component.currentDate = UtilsDate.operate("YEAR", component.currentDate, 1, false);
    component.refresh();
};


/**
 * Show the datepicker popup
 */
ComponentDatePicker.prototype._show = function () {
    // Define this component
    var component = this;

    // Set the previous selected date
    var inputBaseElementVal = $(component.inputBaseElement).val();

    if (inputBaseElementVal != "") {
        component.currentDate = UtilsDate.mySQLToDate(inputBaseElementVal);
    }

    // Generate the container contents
    component.refresh();

    // Create a PopUp to show the calendar
    component.w = ManagerPopUp.window(component.literals.mainTitle, component.mainContainer, {
        width: component.options.width
    });
};


/**
 * Refresh the contents of all component's containers
 */
ComponentDatePicker.prototype.refresh = function () {
    // Define this component
    var component = this;

    // Set the default current date. If no hour container, it will not be considered
    if (!component.currentDate) {
        component.currentDate = component.options.currentDate || UtilsDate.create();
    }

    // Define the containers
    component.mainContainer = $('<div class="componentDatePickerMainContainer row"></div>');
    component.selectorContainer = $('<div class="componentDatePickerSelectorContainer row"></div>');
    component.monthContainer = $('<div class="componentDatePickerMonthContainer row"></div>');
    component.hourContainer = $('<div class="componentDatePickerHourContainer row"></div>');

    $(component.mainContainer).append(component.selectorContainer, component.monthContainer);

    if (component.options.showHourContainer) {
        $(component.mainContainer).append(component.hourContainer);
    }

    // Add the accept button
    component.selectBtn = $('<button class="componentDatePickerSelectBtn">' + component.literals.select + '</button>');
    $(component.mainContainer).append(component.selectBtn);

    $(component.selectBtn).click(function () {
        component._selectDate();
    });

    // Do the container renders
    component._renderSelectorContainer();
    component._renderMonthContainer();

    if (component.options.showHourContainer) {
        component._renderHourContainer();
    }

    // Refresh the popup
    $(component.w).html(component.mainContainer);
};


/**
 * Render the selector container contents
 */
ComponentDatePicker.prototype._renderSelectorContainer = function () {
    // Define this component
    var component = this;

    // Generate the selector container
    component.previousYearBtn = $('<i class="componentDatePickerPreviousYearBtn unselectable"></i>');
    component.nextYearBtn = $('<i class="componentDatePickerNextYearBtn unselectable"></i>');
    component.previousMonthBtn = $('<i class="componentDatePickerPreviousMonthBtn unselectable"></i>');
    component.nextMonthBtn = $('<i class="componentDatePickerNextMonthBtn unselectable"></i>');

    // Generate the rows
    var yearRow = $('<div class="row componentDatePickerYearRow unselectable"></div>');
    var monthRow = $('<div class="row componentDatePickerMonthRow unselectable"></div>');

    // Append to the selectorContainer
    $(yearRow).append(component.previousYearBtn, $('<span class="componentDatePickerCurrentYear fontBold"> ' + UtilsDate.getYear(component.currentDate) + '</span>'), component.nextYearBtn);
    $(monthRow).append(component.previousMonthBtn, $('<span class="componentDatePickerCurrentMonth fontBold"> ' + component.literals.months[UtilsDate.getMonthName(component.currentDate)] + '</span>'), component.nextMonthBtn);
    $(component.selectorContainer).empty();
    $(component.selectorContainer).append(yearRow, monthRow);

    // Generate the events
    $(component.previousYearBtn).click(function () {
        component.goToPreviousYear();
    });
    $(component.nextYearBtn).click(function () {
        component.goToNextYear();
    });
    $(component.previousMonthBtn).click(function () {
        component.goToPreviousMonth();
    });
    $(component.nextMonthBtn).click(function () {
        component.goToNextMonth();
    });
};


/**
 * Render the month container contents
 */
ComponentDatePicker.prototype._renderMonthContainer = function () {
    // Define this component
    var component = this;

    // Empty the monthContainer
    $(component.monthContainer).empty();

    // Generate the week day labels list
    var dayLabelsList = $('<ul class="row componentDatePickerDayLabelsList"></ul>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['MONDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['TUESDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['WEDNESDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['THURSDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['FRIDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['SATURDAY'] + '</p></li>');
    $(dayLabelsList).append('<li class="componentDatePickerCell"><p class="fontBold">' + component.literals.days['SUNDAY'] + '</p></li>');

    $(component.monthContainer).append(dayLabelsList);

    // Generate the month day numbers list through the currentDate
    var monthDayNumbersList = $('<ul class="row componentDatePickerMonthDayNumbersList"></ul>');
    var monthInfo = UtilsDate.getFullMonthInfo(component.currentDate);

    // Fill the first empty days
    var startingDay = monthInfo.days[0].dayWeekNumber;
    var daysCounter = 0, i = 0;

    for (i; i < startingDay; i++) {
        $(monthDayNumbersList).append('<li class="componentDatePickerCell"></li>');
        daysCounter++;
    }

    // Print the month numbers
    $(monthInfo.days).each(function (k, v) {
        var cell = $('<li class="componentDatePickerCell componentDatePickerCellSelectable"><p>' + v.dayMonthNumber + '</p></li>');

        // Add weekend class
        if (v.dayWeekNumber > 4) {
            $(cell).addClass("componentDatePickerCellWeekend");
        }

        // Add selected class
        if (component.currentDate && UtilsDate.getDay(component.currentDate) == v.dayMonthNumber) {
            $(cell).addClass("componentDatePickerCellSelected");
        }

        $(monthDayNumbersList).append(cell);
        daysCounter++;

        // Add the click event listener to the cell
        $(cell).click(function () {
            component.currentDate = UtilsDate.create(
                UtilsDate.getYear(component.currentDate),
                UtilsDate.getMonth(component.currentDate),
                v.dayMonthNumber,
                UtilsDate.getHour(component.currentDate),
                UtilsDate.getMinute(component.currentDate),
                UtilsDate.getSecond(component.currentDate)
            );
            component._renderMonthContainer();
        });
    });

    // Print the last empty days
    for (i = daysCounter; i < 42; i++) {
        $(monthDayNumbersList).append('<li class="componentDatePickerCell"></li>');
    }

    // Append the list to the month container
    $(component.monthContainer).append(monthDayNumbersList);
};


/**
 * Render the hour container
 */
ComponentDatePicker.prototype._renderHourContainer = function () {
    // Define this component
    var component = this;

    // Define the hours selector
    var hoursSelector = $('<select class="componentDatePickerHoursSelector"></select>'), i;

    for (i = 0; i < 24; i++) {
        $(hoursSelector).append('<option value="' + i + '" ' + (i == UtilsDate.getHour(component.currentDate) ? 'selected' : '') + '>' + i + '</option>');
    }

    // Define the minutes selector
    var minutesSelector = $('<select class="componentDatePickerMinutesSelector"></select>');

    for (i = 0; i < 60; i++) {
        $(minutesSelector).append('<option value="' + i + '" ' + (i == UtilsDate.getMinute(component.currentDate) ? 'selected' : '') + '>' + i + '</option>');
    }

    // Define the seconds selector
    var secondsSelector = $('<select class="componentDatePickerSecondsSelector"></select>');

    for (i = 0; i < 60; i++) {
        $(secondsSelector).append('<option value="' + i + '" ' + (i == UtilsDate.getSecond(component.currentDate) ? 'selected' : '') + '>' + i + '</option>');
    }

    // Do the appends to the container
    $(component.hourContainer).empty();
    $(component.hourContainer).append(
        '<p class="componentDatePickerHoursP">' + component.literals.hour + ':</p>',
        '<p class="componentDatePickerMinutesP">' + component.literals.minute + ':</p>',
        '<p class="componentDatePickerSecondsP">' + component.literals.second + ':</p>',
        hoursSelector,
        minutesSelector,
        secondsSelector
    );

    // Generate the select change events
    $(hoursSelector).change(function () {
        component.currentDate = UtilsDate.create(
            UtilsDate.getYear(component.currentDate),
            UtilsDate.getMonth(component.currentDate),
            UtilsDate.getDay(component.currentDate),
            $(this).val(), $(minutesSelector).val(), $(secondsSelector).val());
    });

    $(minutesSelector).change(function () {
        component.currentDate = UtilsDate.create(
            UtilsDate.getYear(component.currentDate),
            UtilsDate.getMonth(component.currentDate),
            UtilsDate.getDay(component.currentDate),
            $(hoursSelector).val(), $(this).val(), $(secondsSelector).val());
    });

    $(secondsSelector).change(function () {
        component.currentDate = UtilsDate.create(
            UtilsDate.getYear(component.currentDate),
            UtilsDate.getMonth(component.currentDate),
            UtilsDate.getDay(component.currentDate),
            $(hoursSelector).val(), $(minutesSelector).val(), $(this).val());
    });
};


/**
 * Select a date
 */
ComponentDatePicker.prototype._selectDate = function () {
    // Define this component
    var component = this;

    // Set the date to the input base element
    var date = UtilsDate.toMySQL(component.currentDate);

    $(component.inputBaseElement).val(date);

    if (component.onSelectCallback) {
        component.onSelectCallback.apply(null, [component.getCurrentDate()]);
    }

    // Close the datepicker
    if (component.w) {
        ManagerPopUp.closeWindow($(component.w)[0]);
    }
};
