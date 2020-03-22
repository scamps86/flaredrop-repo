/**
 * Component Divided box that we can add some resizable containers
 *
 * @param parentElement The parent element
 * @param minItemsWidth Set the minimal width for each sub boxes in pixels. 50 by default
 * @param resizeAction The event action called when resizing. Not mandatory
 */
function ComponentDividedBox(parentElement, minItemsWidth, resizeAction) {

    // Define this component
    var component = this;

    // Set the parent element
    component.parentElement = parentElement;

    // Set the refreshing time
    component._REFRESHING_TIME = 50;

    // Set the container
    component.container = $('<ul class="componentDividedBox"></ul>');

    // States
    component.mouseDown = null;
    component.mouseStartX = 0;
    component.mouseFinishX = 0;
    component.prevWidth = 0;
    component.thisWidth = 0;

    // Options
    component.minItemsWidth = minItemsWidth === undefined ? 50 : minItemsWidth;

    // Set the resize action
    component.resizeAction = resizeAction;

    // Append the component to the parent element
    $(component.parentElement).append(component.container);

    // Catch the window resize function to resize the box
    $(window).resize(function () {

        component.reset();
    });
}


/**
 * Reset the item sizes to the starting ones
 */
ComponentDividedBox.prototype.reset = function () {

    // Define this component
    var component = this;

    $(component.container).css({
        "width": "100%"
    });

    $(component.container).find("li.componentDividedBoxItem").each(function (k, v) {

        $(v).css({
            "width": $(v).attr("w")
        });
    });
};


/**
 * Add a sub box to the divided box
 *
 * @param contentElement The DOM element to add
 * @param percentWidth The percent width that will be applied on this sub box by default]
 */
ComponentDividedBox.prototype.add = function (contentElement, percentWidth) {

    // Define this component
    var component = this;

    var li = $('<li w="' + percentWidth + '%" class="unselectable componentDividedBoxItem"></li>');

    $(li).css({
        "width": percentWidth + "%"
    });

    // Create the helper
    var helper = $('<div class="unselectable transitionFast componentDividedBoxHelper"></div>');

    // Append the content and helper to the item (the helper not on the first item)
    if ($(component.container).html() != "") {
        $(li).append(helper);
    }

    $(li).append(contentElement);

    // Append the item to the component's container
    $(component.container).append(li);

    // Auto refresh helper
    var intId = setInterval(function () {
        if (!$(helper).parents().last().is(document.documentElement)) {
            clearInterval(intId);
        }
        $(helper).height($(component.container).height());
    }, component._REFRESHING_TIME);

    // Create the events
    $(helper).mousedown(function (e) {
        component._downHandler(this, e.pageX);
    });

    $(helper).on("touchstart", function (e) {

        e = e.originalEvent.touches[0];
        component._downHandler(this, e.pageX);
    });

    $(document).mouseup(function () {

        component._upHandler();
    });

    $(helper).on("touchend", function () {

        component._upHandler();
    });

    $(document).mousemove(function (e) {

        component._dragProcessHandler(e.pageX);
    });

    $(document).on("touchmove", function (e) {

        e = e.originalEvent.touches[0];
        component._dragProcessHandler(e.pageX);
    });
};


/**
 * Drag process event handler
 *
 * @param position The X cursor position
 */
ComponentDividedBox.prototype._dragProcessHandler = function (position) {

    // Define this component
    var component = this;

    if (component.mouseDown) {


        component.mouseFinishX = position;

        if (component.prevWidth <= 0) {
            component.prevWidth = $(component.mouseDown).parent().prev().width();
        }

        if (component.thisWidth <= 0) {
            component.thisWidth = $(component.mouseDown).parent().width();
        }

        // Calculate widths
        var thisWidth = component.thisWidth + component.mouseStartX - component.mouseFinishX;
        var prevWidth = component.prevWidth - component.mouseStartX + component.mouseFinishX;

        // Prevent resizes more than the max allowed
        if (prevWidth <= component.minItemsWidth) {

            prevWidth = component.minItemsWidth;
        }

        if (thisWidth <= component.minItemsWidth) {

            thisWidth = component.minItemsWidth;
        }

        if (prevWidth > component.minItemsWidth && thisWidth > component.minItemsWidth) {

            // Resize all items as not percentual
            $(component.container).css({
                "width": $(component.container).width() + "px"
            });

            $(component.container).find("li.componentDividedBoxItem").each(function (k, i) {
                $(i).css({
                    "width": $(i).width() + "px"
                });
            });

            // Resize the previous item and this one
            $(component.mouseDown).parent("li.componentDividedBoxItem").css({
                "width": thisWidth + "px"
            });
            $(component.mouseDown).parent("li.componentDividedBoxItem").prev().css({
                "width": prevWidth + "px"
            });

            // Verify if the summatory of all items width is the container width (percent is not exactly), and resize the last item if necessary
            var totalWidth = 0;
            var lastItem = null;

            $(component.container).find("li.componentDividedBoxItem").each(function (k, i) {

                totalWidth += $(i).width();
                lastItem = i;
            });

            if (totalWidth > $(component.container).width()) {
                $(lastItem).css({
                    "width": $(lastItem).width() - (totalWidth - $(component.container).width()) + "px"
                });
            }

            // Dispatch the resize event if defined
            if (component.resizeAction !== undefined) {

                component.resizeAction.apply();
            }
        }
    }
};


/**
 * On helper click/touch handler
 *
 * @param helper The helper DOM element
 * @param position The X position where the helper is clicked/touched
 */
ComponentDividedBox.prototype._downHandler = function (helper, position) {

    // Define this component
    var component = this;

    component.mouseDown = helper;
    component.mouseStartX = position;
    $(component.mouseDown).addClass("componentDividedBoxHelperDown");
};


/**
 * On helper up handler
 */
ComponentDividedBox.prototype._upHandler = function () {

    // Define this component
    var component = this;

    if (component.mouseDown) {
        $(component.mouseDown).removeClass("componentDividedBoxHelperDown");
        component.mouseDown = null;
        component.prevWidth = 0;
        component.thisWidth = 0;
    }
};