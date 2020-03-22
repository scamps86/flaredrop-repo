function UtilsTimerClass() {

    // Define this utils
    var utils = this;

    // The delays that will be cancelled
    utils.delaysToCancel = {};

    // The current applying delays
    utils.delays = {};

    // The defined countdowns
    utils.countdowns = {};
}


/**
 * Call a function when a timer finishes
 *
 * @param duration The timer duration in miliseconds
 * @param action The action function call
 * @param id The delay identification to allow be cancelled
 */
UtilsTimerClass.prototype.delay = function (duration, action, id) {

    // Define this utils
    var utils = this;

    id = id === undefined ? "default" : id;

    // Add the delay to the current applying delays
    utils.delays[id] = id;

    setTimeout(function () {
        // Remove the delay from the current applying delays
        delete utils.delays[id];

        // If no cancel, apply the action function
        if (utils.delaysToCancel[id] === undefined) {
            action.apply();
        }
        else {
            delete utils.delaysToCancel[id];
        }
    }, duration);
};


/**
 * Cancel a current applied delay by its id
 *
 * @param id The delay's id
 */
UtilsTimerClass.prototype.cancelDelay = function (id) {
    // Define this utils
    var utils = this;

    // Only cancel if the delay exists
    if (utils.delays[id] !== undefined) {
        utils.delaysToCancel[id] = id;
    }
};


/**
 *Initialize a countdown
 *
 * @param parentElement The parent element where to print the countdown
 * @param countdownId The countdown id. This ID cannot be similar than another countdown id so it makes conflicts.
 * @param timeRemaining The time remaining units (seconds)
 * @param interval The interval time in ms. (1000 by default)
 * @param formatUnits The format object strings for the formatter: {days, hours, minutes, seconds}. If not defined it will use the defaults.
 * @param intervalCallBack The interval callback
 * @param finishCallBack The callback when the timeout finishes
 */
UtilsTimerClass.prototype.countdown = function (parentElement, countdownId, timeRemaining, interval, formatUnits, intervalCallBack, finishCallBack) {
    // Define this utils
    var utils = this;

    // Options
    interval = interval === undefined ? 1000 : parseInt(interval);

    // Set the formatter units
    formatUnits = formatUnits || {};
    formatUnits = {
        days: formatUnits.days || "d ",
        hours: formatUnits.hours || "h ",
        minutes: formatUnits.minutes || "m ",
        seconds: formatUnits.seconds || "s"
    };

    // Update the countdown
    utils.countdowns[countdownId] = {
        parentElement: parentElement,
        timeRemaining: parseInt(timeRemaining),
        interval: interval,
        formatUnits: formatUnits,
        intervalCallBack: intervalCallBack,
        finishCallBack: finishCallBack
    };

    // Print the countdown actual value
    var toPrint = formatUnits !== undefined ? UtilsFormatter.time(utils.countdowns[countdownId].timeRemaining, formatUnits.days, formatUnits.hours, formatUnits.minutes, formatUnits.seconds) : utils.countdowns[countdownId].timeRemaining;
    $(parentElement).html(toPrint);

    // Dispatch the finish callbacks
    if (utils.countdowns[countdownId].timeRemaining <= 0) {
        if (finishCallBack !== undefined) {
            utils.stopCountdown(countdownId);
            finishCallBack.apply(null, [countdownId]);
            return;
        }
    }
    else {
        if (intervalCallBack !== undefined) {
            intervalCallBack.apply(null, [countdownId]);
        }
    }

    // Create the countdown's delay. The delay id will be the countdown id
    utils.delay(interval, function () {
        utils.countdown(parentElement, countdownId, utils.countdowns[countdownId].timeRemaining - 1, interval, formatUnits, intervalCallBack, finishCallBack);
    }, countdownId);
};


/**
 * Update the countdown remaining time
 *
 * @param countdownId The countdown id
 * @param timeRemaining The remaining time
 */
UtilsTimerClass.prototype.updateCountdown = function (countdownId, timeRemaining) {
    // Define this utils
    var utils = this;

    if (utils.countdowns[countdownId]) {
        utils.countdowns[countdownId].timeRemaining = parseInt(timeRemaining);
    }
};


/**
 *Stop the countdown
 *
 * @param countdownId The countdown id
 */
UtilsTimerClass.prototype.stopCountdown = function (countdownId) {
    // Define this utils
    var utils = this;
    utils.cancelDelay(countdownId);
};


/**
 *Continue an stopped countdown
 *
 * @param countdownId The countdown id
 */
UtilsTimerClass.prototype.continueCountdown = function (countdownId) {
    // Define this utils
    var utils = this;

    if (utils.countdowns[countdownId]) {
        utils.countdown(utils.countdowns[countdownId].parentElement, countdownId, utils.countdowns[countdownId].timeRemaining, utils.countdowns[countdownId].formatUnits, utils.countdowns[countdownId].intervalCallBack, utils.countdowns[countdownId].finishCallBack);
    }
};