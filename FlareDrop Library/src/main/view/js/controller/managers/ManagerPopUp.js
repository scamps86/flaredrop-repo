/** HTML PopUp manager */
function ManagerPopUpClass() {
    this._REFRESHING_TIME = 50;
}


/**
 * Show a dialog with a title, message and different options
 *
 * @param title The dialog title
 * @param message The dialog message
 * @param buttons Array containing the button information. Each button must be an object containing 2 properties: "label" and "action" (not mandatory). the label is the text that will be shown inside the button and the action is the function that
 * will be called when the button is clicked
 * @param options Object to configure the dialog. It reads these properties: "width", "className" and "fadeTime". Width is the dialog window width (400 by default). Class name can be "error", "info", "warning", "success", "default" (default by
 * default), and fade time (200 by default)
 * @param closeAction The action that will be called when the dialog is closed. (not mandatory)
 */
ManagerPopUpClass.prototype.dialog = function (title, message, buttons, options, closeAction) {

    // Define this manager
    var manager = this;

    // Initialize the options if not defined
    options = options === undefined ? {} : options;

    // Get the options fade time
    var fadeTime = options.fadeTime === undefined ? 200 : options.fadeTime;

    // Get the options width
    var width = options.width === undefined ? 400 : options.width;

    // Get the options class name
    var className = options.className === undefined ? "default" : options.className;

    // Define a background
    var background = $('<div class="managerPopUpBackground"></div>');

    // Define a window
    var w = $("<div></div>");
    $(w).addClass("managerPopUpDialog " + className);
    $(w).attr("defaultWidth", width);

    // Create top container
    var topContainer = $('<div><p class="fontBold">' + title + '</p></div>');
    $(topContainer).addClass("managerPopUpTopContainer");

    // Create close button
    var closeBtn = $('<div class="managerPopUpCloseBtn"></div>');

    // Create the message container
    var messageContainer = $('<div class="managerPopUpMessageContainer"><p>' + message + "</p></div>");

    // Create the options container
    var optionsContainer = $('<div class="managerPopUpOptionsContainer"></div>');

    $(buttons).each(function (k, b) {

        var op = $('<button type="button">' + b.label + '</button>');

        $(op).click(function () {
            if (b.action !== undefined) {

                b.action.apply();
            }

            $(closeBtn).trigger("click");
        });

        $(optionsContainer).append(op);
    });

    // Do the appends
    $(w).append(closeBtn, topContainer, messageContainer, optionsContainer);
    $(background).append(w);
    $("body").append(background);

    // Fade in the PopUp
    $(w).hide();
    $(background).hide();

    $(background).fadeIn(fadeTime, function () {
        $(w).fadeIn(fadeTime);
    });

    // Close event
    $(closeBtn).click(function () {
        $(w).fadeOut(fadeTime, function () {
            $(background).fadeOut(fadeTime, function () {
                $(background).empty();
                $(background).remove();

                if (closeAction !== undefined) {
                    closeAction.apply();
                }
            });
        });
    });

    // Center and resize the popup
    manager._screenCenter(w);
};


/**
 * Popup window with an HTML content. The HTML content can be modified after the window creation
 *
 * @param title The window title
 * @param content The content element or HTML code
 * @param options Object to configure the dialog. It reads these properties: "width", "maxHeight" and "fadeTime". Width is the window width (500 by default). MAxHeight is the window maximum height. Fade time
 * (200 by default)
 * @param closeAction The action that will be called when the dialog is closed. (not mandatory)
 * @param createAction The action that will be called when the dialog is created. (not mandatory)
 *
 * @returns The window HTML container that can be modified
 */
ManagerPopUpClass.prototype.window = function (title, content, options, closeAction, createAction) {

    // Define this manager
    var manager = this;

    // Initialize the options if not defined
    options = options === undefined ? {} : options;

    // Get the options fade time
    var fadeTime = options.fadeTime === undefined ? 200 : options.fadeTime;

    // Get the options width
    var width = options.width === undefined ? 500 : options.width;

    // Get the options height
    var maxHeight = options.maxHeight === undefined ? "" : options.maxHeight;

    // Define a background
    var background = $('<div class="managerPopUpBackground"></div>');

    // Define a window
    var w = $("<div></div>");
    $(w).addClass("managerPopUpWindow");
    $(w).attr("defaultWidth", width);

    // Create top container
    var topContainer = $('<div><p class="fontBold">' + title + '</p></div>');
    $(topContainer).addClass("managerPopUpTopContainer");

    // Create close button
    var closeBtn = $('<div class="managerPopUpCloseBtn"></div>');

    // Create the content HTML container
    var contentHtmlContainer = $('<div class="managerPopUpContentHtmlContainer"></div>');
    $(contentHtmlContainer).append(content);

    if (maxHeight != "") {
        $(contentHtmlContainer).css({"max-height": maxHeight + "px"});
    }

    // Do the appends
    $(w).append(closeBtn, topContainer, contentHtmlContainer);
    $(background).append(w);
    $("body").append(background);

    // Fade in the PopUp
    $(w).hide();
    $(background).hide();

    $(background).fadeIn(fadeTime, function () {
        $(w).fadeIn(fadeTime);
    });

    // Close event
    $(closeBtn).click(function () {
        $(w).fadeOut(fadeTime, function () {
            $(background).fadeOut(fadeTime, function () {
                $(background).remove();

                if (closeAction !== undefined) {
                    closeAction.apply();
                }
            });
        });
    });

    // Center and resize the popup
    manager._screenCenter(w);

    // Create event
    if (createAction !== undefined) {
        createAction.apply();
    }

    // Return the popup container element
    return contentHtmlContainer;
};


/**
 * Popup an image
 *
 * @param imageElement The image element to be shown
 * @param fadeTime The fade time in ms (200 by default)
 * @param closeAction The action that will be called when the dialog is closed. (not mandatory)
 */
ManagerPopUpClass.prototype.image = function (imageElement, fadeTime, closeAction) {

    // Define this manager
    var manager = this;

    // Get the options fade time
    fadeTime = fadeTime === undefined ? 200 : fadeTime;

    // Define a background
    var background = $('<div class="managerPopUpBackground"></div>');

    // Define a window
    var w = $("<div></div>");
    $(w).addClass("managerPopUpWindow");

    // Create the content HTML container
    var contentHtmlContainer = $('<div class="managerPopUpContentHtmlContainer"></div>');
    $(contentHtmlContainer).css({"text-align": "center"});

    // Add the image class
    $(imageElement).addClass("managerPopUpContentImage");

    // Do the appends
    $(contentHtmlContainer).append(imageElement);
    $(w).append(contentHtmlContainer);
    $(background).append(w);
    $("body").append(background);

    // Hide the window and background
    $(w).hide();
    $(background).hide();

    // Close event
    $(background).click(function () {
        $(w).fadeOut(fadeTime, function () {
            $(background).fadeOut(fadeTime, function () {
                $(background).remove();

                if (closeAction !== undefined) {
                    closeAction.apply();
                }
            });
        });
    });

    // Center and resize the popup
    manager._screenCenter(w);

    // Initialize an interval
    var intId = setInterval(process, manager._REFRESHING_TIME);
    process();

    function process() {
        // Stop the interval if the popup is closed
        if (!$(background).parents().last().is(document.documentElement)) {
            clearInterval(intId);
        }

        // Fade in the PopUp when the image width is loaded
        if (imageElement[0] !== undefined) {
            if (imageElement[0].width > 0 && !$(background).is(":visible")) {
                if ($(w).attr("defaultWidth") === undefined) {
                    $(w).attr("defaultWidth", imageElement[0].width);
                }
                $(background).fadeIn(fadeTime, function () {
                    $(w).fadeIn(fadeTime);
                });
            }
        }
    }
};


/**
 * Show a full screen waiting window. This window only can be closed calling the closeWait method.
 *
 * @param contentHtml The HTML content to be placed on the center of screen
 * @param fadeTime The fade time in ms. (200 by default)
 */
ManagerPopUpClass.prototype.wait = function (contentHtml, fadeTime) {

    // Define this manager
    var manager = this;

    // Verify if there is another wait window
    if ($("div.managerPopUpWait").length > 0) {
        return;
    }

    // Get the options fade time
    if (fadeTime === undefined) {
        fadeTime = 200;
    }

    // Set contentHtml as empty if not defined
    if (contentHtml === undefined) {
        contentHtml = "";
    }

    // Define a background
    var background = $('<div class="unselectable managerPopUpBackground managerPopUpWait"></div>');
    $(background).attr("fadeTime", fadeTime);

    // Define the waiting content
    var w = $('<div class="unselectable managerPopUpWaitContent"></div>');
    $(w).html(contentHtml);
    $(w).attr("defaultWidth", 0);

    // Do the appends
    $(background).append(w);
    $("body").append(background);

    // Fade in the PopUp
    $(background).hide();
    $(background).fadeIn(fadeTime);

    // Center and resize the popup
    manager._screenCenter(w);
};


/**
 * Close an opened waiting window
 */
ManagerPopUpClass.prototype.closeWait = function () {
    var fadeTime = $("div.managerPopUpWait").attr("fadeTime");
    $("div.managerPopUpWait").fadeOut(fadeTime, function () {
        $(this).remove();
    });
};


/**
 * Close all opened dialogs or windows
 */
ManagerPopUpClass.prototype.closeAll = function () {
    $("div.managerPopUpBackground").find("div.managerPopUpCloseBtn").trigger("click");
};


/**
 * Close the specified window
 *
 * @param windowContainer The window container element
 */
ManagerPopUpClass.prototype.closeWindow = function (windowContainer) {
    var e = $(windowContainer).parents(".managerPopUpWindow")[0];
    e = $(e).find(".managerPopUpCloseBtn")[0];
    $(e).trigger("click");
};

/**
 * Center and resize (if necessary) permanently the popup on the screen
 *
 * @param windowElement The popup window element
 */
ManagerPopUpClass.prototype._screenCenter = function (windowElement) {
    // Get this manager
    var manager = this, cWidth = 0;

    // Initialize the interval
    var intId = setInterval(process, manager._REFRESHING_TIME);
    process();

    function process() {
        // Stop the interval if the popup is closed
        if (!$(windowElement).parents().last().is(document.documentElement)) {
            clearInterval(intId);
        }

        // Resize the popup
        if ($(windowElement).attr("defaultWidth") >= $(window).width() - 40) {
            cWidth = $(window).width() - 40;
            $(windowElement).width(cWidth);
        }
        else {
            cWidth = $(windowElement).attr("defaultWidth");
            $(windowElement).width(cWidth);
        }

        var content = $(windowElement).find("div.managerPopUpContentHtmlContainer, div.managerPopUpMessageContainer, img.managerPopUpContentImage");
        var padding = 80;

        if (content !== undefined) {
            if ($(content).hasClass("managerPopUpMessageContainer")) {
                padding = 130;
            }
            $(content).css({"max-height": ($(window).height() - padding) + "px"});
        }

        // Center the popup
        $(windowElement).css({
            "margin-left": -(cWidth / 2) - 10 + "px",
            "margin-top": -($(windowElement).height() / 2) - 15 + "px"
        });
    }
};