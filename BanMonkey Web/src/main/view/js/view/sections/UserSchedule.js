$(document).ready(function () {
    SystemWeb.initializeSectionJs("userSchedule", function () {

        // Refresh schedules
        refreshSchedules();

        // Add the add new schedules button event
        $("#addSchedule").click(function () {
            showAddNewSchedulePopUp();
        });
    });
});


/**
 * Show a popup to add a new schedule (product selector)
 */
function showAddNewSchedulePopUp() {
    $.get(APL_URL, function (data) {
        ManagerPopUp.window(SELECT_PRODUCT, data, [], undefined, function () {
            $("#auctionProductsList li").click(function () {
                showAddNewSchedulePopUp2($(this).attr("pid"));
            });
        });
    });
}


/**
 * Do the call to remove a bid schedule and refresh them
 *
 * @param bidScheduleId
 */
function removeSchedule(bidScheduleId) {
    $.ajax({
        type: "POST",
        url: RS_URL,
        data: {bidScheduleId: bidScheduleId},
        success: function (data) {
            if (data != "") {
                ManagerPopUp.dialog(DIALOG_ERROR, REMOVE_ERROR, [
                    {label: DIALOG_ACCEPT}
                ], {className: "error"});
            }
            else {
                refreshSchedules();
            }
        }
    });
}


/**
 * Show a popup to add new schedule (options selector
 * )
 * @param productId The selected product id
 */
function showAddNewSchedulePopUp2(productId) {

    // Close previous dialog
    ManagerPopUp.closeAll();

    // Create the form
    var form = $('<form id="frmAddNewSchedule"></form>');
    $(form).attr("serviceUrl", AS_URL);
    $(form).append('<input type="hidden" name="frmProductId" value="' + productId + '" />');
    $(form).append('<p>' + MAX_BANS + '</p>');
    $(form).append('<input type="text" name="frmMaxBans" maxlength="4" validate="fill;numberNatural" validateCondition="AND" validateErrorMessage="' + MAX_BANS_ERROR + ';' + DIALOG_ERROR + '" />');
    $(form).append('<p>' + MAX_PRICE + '</p>');
    $(form).append('<input type="text" name="frmMaxPrice" maxlength="10" validate="fill;number" validateCondition="AND" validateErrorMessage="' + MAX_PRICE_ERROR + ';' + DIALOG_ERROR + '" />');
    $(form).append('<input type="submit" value="' + DIALOG_ACCEPT + '"/>');

    // Show the popup
    ManagerPopUp.window(DEFINE_SCHEDULE, form);

    // Add the form to the ManagerForm
    ManagerForm.add(form, function () {
        refreshSchedules();
        ManagerPopUp.closeAll();
    }, function () {
        ManagerPopUp.dialog(DIALOG_ERROR, ADD_SCHEDULE_ERROR, [
            {label: DIALOG_ACCEPT}
        ], {className: "error"});
    });
}


/**
 * Update the schedules by ajax
 */
function refreshSchedules() {
    $.post(RUS_URL, function (schedules) {

        schedules = UtilsConversion.jsonToObject(schedules);
        $("#userSchedulesList").empty();

        $(schedules).each(function (k, v) {
            var li = $('<li></li>');

            if (v.productPicture !== undefined) {
                $(li).append('<img class="productPicture" src="' + v.productPicture + '"/>');
            }

            $(li).append('<span class="productName fontBold">' + v.productName + '</span>');
            $(li).append('<span class="maxBans">&#60; ' + v.maxBans + ' Bans</span>');
            $(li).append('<span class="maxPrice">&#60; ' + UtilsFormatter.currency(v.maxPrice) + '</span>');

            // Remove option
            var remove = $('<button class="removeBtn" bid="' + v.bidScheduleId + '">' + REMOVE + '</button>');
            $(li).append(remove);

            $(remove).click(function () {
                removeSchedule($(this).attr("bid"));
            });

            $("#userSchedulesList").append(li);
        });
    });
}